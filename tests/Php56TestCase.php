<?php

use PHPUnit\Framework\TestCase as BaseTestCase;

class Php56TestCase extends BaseTestCase
{
    protected function setUp()
    {
        if (method_exists($this, '_setUp')) {
            $this->_setUp();
        }
    }

    protected function tearDown()
    {
        if (method_exists($this, '_tearDown')) {
            $this->_tearDown();
        }
    }
}
