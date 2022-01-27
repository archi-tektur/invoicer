<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/src_architool')
    ->in(__DIR__.'/bin')
    ->in(__DIR__.'/tests')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
    ])
    ->setFinder($finder)
;
