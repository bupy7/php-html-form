<?php declare(strict_types=1);

/**
 * Configuration of code style fixer and checker for this library.
 * This configuration compatible with friendsofphp/php-cs-fixer "^3.43.1".
 */

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
