<?php

namespace Andychey\Csv;

use PHPUnit_Framework_TestCase;


class WriterTest extends PHPUnit_Framework_TestCase
{
    public function testSave()
    {
        $data = array(
            array('姓名', '年龄'),
            array('搞毛', 20),
            array('哈哈', 30),
            array('呵呵', 123456789012),
            array('嘻嘻', 12345678901),
        );

        $out = __DIR__ . '/data/out.csv';
        $write = new Writer($data);
        $write->save($out);
        $this->assertFileExists($out);
    }
}
