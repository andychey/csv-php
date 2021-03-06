<?php
namespace Andychey\Csv;

use InvalidArgumentException;


class Reader
{
    /**
     * 直接将csv文件加载到数组中
     *
     * @param $filename
     * @param $columns
     *
     * @return array
     */
    public static function loadToArray($filename, array $columns = array())
    {
        self::checkFile($filename);

        $fh = fopen($filename, 'r');

        return self::getCsvData($fh, $columns);
    }

    /**
     * 从csv中取出数据
     *
     * @param $fh
     * @param array $columns
     * @return array
     */
    protected static function getCsvData($fh, array $columns = array())
    {
        $data = array();
        $line = 0;
        while (($buffer = fgets($fh)) !== false) {
            if (! $line) {
                $buffer = str_replace("\xEf\xBB\xBF", '', $buffer);
            }
            $data[] = self::filterColumns(
                array_map(function ($item) {return trim($item, "\r\n\t `");}, array_filter(explode(',', $buffer))),
                $columns
            );
            $line ++;
        }
        return $data;
    }

    /**
     * 只取出指定列的内容
     *
     * @param $data
     * @param array $columns
     * @return array
     */
    protected static function filterColumns($data, array $columns = array())
    {
        if (empty($columns)) {
            return $data;
        }
        $tmp = array();
        foreach ($columns as $column) {
            if (! isset($data[$column])) {
                continue;
            }
            $tmp[] = $data[$column];
        }
        return $tmp;
    }

    /**
     * 检查文件
     *
     * @param $filename
     */
    protected static function checkFile($filename)
    {
        if (! file_exists($filename)) {
            throw new InvalidArgumentException("File 「{$filename}」 doesn't exist");
        }
    }
}
