<?php

namespace Andychey\Csv;


class Reader
{
    /**
     * 文件名
     *
     * @var
     */
    protected $filename;

    /**
     * 文件句柄
     *
     * @var resource
     */
    protected $fh;

    /**
     * Reader constructor
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->checkFile($filename);
        $this->filename = $filename;
        $this->fh = fopen($filename, 'r');
    }

    /**
     * 转为数组
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getCsvData($this->fh);
    }

    /**
     * 直接将csv文件加载到数组中
     *
     * @param $filename
     * @return array
     */
    public static function loadToArray($filename)
    {
        self::checkFile($filename);

        $fh = fopen($filename, 'r');

        return self::getCsvData($fh);
    }

    /**
     * 从csv中取出数据
     *
     * @param $fh
     * @param array $columns
     * @return array
     */
    protected static function getCsvData($fh, $columns = array())
    {
        $data = array();
        while (($buffer = fgets($fh)) !== false) {
            $data[] = self::filterColumns(explode(',', $buffer), $columns);
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
            throw new \InvalidArgumentException("File 「{$filename}」 doesn't exist");
        }
    }
}