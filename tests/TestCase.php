<?php

if (version_compare(PHP_VERSION, '7.1.0', '>=')) {
    require_once __DIR__ . '/Php71TestCase.php';

    class TestCase extends Php71TestCase
    {
    }
} else {
    require_once __DIR__ . '/Php56TestCase.php';

    class TestCase extends Php56TestCase
    {
    }
}
