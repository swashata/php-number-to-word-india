<?php
namespace ntwIndia\Test;

class ntwIndiaTest extends \PHPUnit_Framework_TestCase {
	public $ntw;

	public function __construct() {
		$this->ntw = new NTW_India();
	}

	public function test_true_is_true() {
		$foo = true;
		$this->assertTrue( $foo );
	}
}
