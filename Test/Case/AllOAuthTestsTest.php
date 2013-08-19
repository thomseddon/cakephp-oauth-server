<?php

class AllOAuthTestsTest extends PHPUnit_Framework_TestSuite {

	public static function suite() {
		$suite = new CakeTestSuite('OAuth Tests');
		$path = CakePlugin::path('OAuth') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectory($path . 'Model' . DS . 'Behavior');
		return $suite;
	}

}
