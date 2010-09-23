<?php

class MF_AutoloaderTest extends PHPUnit_Framework_TestCase
{
        public function testDoesAutoload()
        {
                $obj = new MF_AutoloaderData();

                // if we get here, then the test has passed
                $this->assertTrue(true);
        }
}
