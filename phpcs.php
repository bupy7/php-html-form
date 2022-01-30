<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude(__DIR__ . '/vendor')
    ->exclude(__DIR__ . '/logs')
    ->exclude(__DIR__ . '/build');

$config = new Config();
$config->setRules([
    '@PSR2' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
]);
$config->setFinder($finder);

return $config;
