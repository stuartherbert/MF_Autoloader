<?php

__mf_init_namespace('\\MF\\Autoloader');
__mf_init_tests('\\MF\\Autoloader');

class MF_AutoloaderTest extends PHPUnit_Framework_TestCase
{
        public function testDoesAutoload()
        {
                $obj = new MF_AutoloaderData();

                // if we get here, then the test has passed
                $this->assertTrue(true);
        }

        public function testDoesInitNamespace()
        {
                $this->assertTrue(defined('AUTOLOADER_INIT_SUCCESS'));
                $this->assertEquals(AUTOLOADER_INIT_SUCCESS, 1);
        }

        public function testDoesInitTests()
        {
                $this->assertTrue(defined('AUTOLOADER_INITTESTS_SUCCESS'));
                $this->assertEquals(AUTOLOADER_INITTESTS_SUCCESS, 1);
        }
}
