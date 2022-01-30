<?php

if (version_compare(PHP_VERSION, '7.1.0', '>=')) {
    class TestCase extends Php71TestCase
    {
    }
} else {
    class TestCase extends Php56TestCase
    {
    }
}
