<?php

namespace Andychey\Csv;


class Writer
{
    /**
     * 最大数字宽度
     */
    const MAX_NUMBER_WIDTH = 11;

    /**
     * 表头
     *
     * @var array
     */
    protected $head;

    /**
     * 数据
     *
     * @var array
     */
    protected $data;

    /**
     * Writer constructor
     *
     * @param array $head
     * @param array $data
     */
    public function __construct(array $head = array(), array $data = array())
    {
        $this->head = $head;
        $this->data = $data;
    }

    /**
     * 添加一行数据
     *
     * @param array $row
     *
     * @throws Exception
     */
    public function addRow(array $row)
    {
        if (count($row) != count($this->head)) {
            throw new \InvalidArgumentException("The row does't match this head");
        }
        $this->data[] = $row;
    }
}