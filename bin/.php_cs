<?php

$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'no_superfluous_phpdoc_tags' => []
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
            ->ignoreVCS(true)
            ->files()
    )
;

return $config;
