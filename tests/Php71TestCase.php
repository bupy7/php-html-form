<?php

use PHPUnit\Framework\TestCase as BaseTestCase;

class Php71TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        if (method_exists($this, '_setUp')) {
            $this->_setUp();
        }
    }

    protected function tearDown(): void
    {
        if (method_exists($this, '_tearDown')) {
            $this->_tearDown();
        }
    }

    public static function assertRegExp(string $pattern, string $string, string $message = ''): void
    {
        self::assertMatchesRegularExpression($pattern, $string, $message);
    }

    public static function assertNotRegExp(string $pattern, string $string, string $message = ''): void
    {
        self::assertDoesNotMatchRegularExpression($pattern, $string, $message);
    }
}
