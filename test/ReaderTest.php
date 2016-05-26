<?php

namespace Andychey\Csv;

use PHPUnit_Framework_TestCase;


class ReaderTest extends PHPUnit_Framework_TestCase
{
	public static function testSave()
	{
		$data = array(
			array('姓名', '年龄'),
			array('搞毛', 20),
			array('哈哈', 30),
			array('呵呵', 123456789012),
			array('嘻嘻', 12345678901),
		);

		$write = new Writer($data);
		$write->save(__DIR__ . '/data/out.csv');
	}
}
