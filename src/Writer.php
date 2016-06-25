<?php
namespace Andychey\Csv;


class Writer
{
    /**
     * 最大数字宽度
     */
    const MAX_NUMBER_WIDTH = 11;

    /**
     * 数据
     *
     * @var array
     */
    protected $data;

    /**
     * Writer constructor
     *
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * 下载csv
     *
     * @param $filename
     */
    public function download($filename)
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $fh = fopen('php://output', 'w');
        $this->process($fh);
    }

    /**
     * 保存sv
     *
     * @param $filename
     */
    public function save($filename)
    {
        $fh = fopen($filename, 'w');
        $this->process($fh);
    }

    /**
     * 添加一行数据
     *
     * @param array $row
     */
    public function addRow(array $row)
    {
        $this->data[] = $row;
    }

    /**
     * 添加多行数据
     *
     * @param array $data
     */
    public function addAll(array $data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * 处理数据
     *
     * @param $fh
     */
    public function process($fh)
    {
        fwrite($fh, "\xEF\xBB\xBF");
        foreach ($this->data as $row) {
            foreach ($row as & $value) {
                if (is_numeric($value) && strlen($value) > self::MAX_NUMBER_WIDTH) {
                    $value = '`' . $value;
                }
            }
            fwrite($fh, implode(',', $row) . "\r\n");
        }
        fclose($fh);
    }
}
