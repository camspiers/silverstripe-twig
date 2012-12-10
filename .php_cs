<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->name('*.php')
    ->exclude('vendor')
    ->exclude('framework')
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()
    ->finder($finder);