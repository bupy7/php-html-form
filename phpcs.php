<?php declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

$config = new Config();
$config->setRules([
    '@PSR2' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
]);
$config->setFinder($finder);

return $config;
