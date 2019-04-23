<?php

$finder = \PhpCsFixer\Finder::create()
    ->in(__DIR__.'/Classes');

return PhpCsFixer\Config::create()
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
    ])
    ->setLineEnding("\n")
    ;
