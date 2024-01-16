<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('vendor')
    ->exclude('node_modules')
    ->exclude('public')
    ->exclude('uploads')
    ->exclude('frontends')
    ->exclude('migrations')
    ->exclude('docker')
    ->exclude('config')
    ->exclude('assets')
    ->exclude('.git')
    ->exclude('.github')
    ->exclude('_temp')
    ->exclude('cypress')
    ->exclude('translations')
    ->exclude('bin')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
    ])
    ->setFinder($finder)
;
