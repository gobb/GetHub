<?php

// Please note that this is a fail-safe autoloader only to ensure that the classes
// in this library are appropriately loaded.  Ideally you will be including DataFoundry
// in your own autoloader that follows the PSR-0 autoloading proposal in regards
// to namespaces being tied to the directory path.

$classPaths = array();
$classPaths['DataFoundry\\Entity'] = __DIR__ . '/Entity.php';
$classPaths['DataFoundry\\BaseFactory'] = __DIR__ . '/BaseFactory.php';
$classPaths['DataFoundry\\MapFactory'] = __DIR__ . '/MapFactory.php';
$classPaths['DataFoundry\\Test\\EntityTest'] = __DIR__ . '/Test/Cases/EntityTest.php';
$classPaths['DataFoundry\\Test\\BaseFactoryTest'] = __DIR__ . '/Test/Cases/BaseFactoryTest.php';
$classPaths['DataFoundry\\Test\\MapFactoryTest'] = __DIR__ . '/Test/Cases/MapFactoryTest.php';
$classPaths['DataFoundry\\Test\\Helpers\\Entity'] = __DIR__ . '/Test/Helpers/Entity.php';
$classPaths['DataFoundry\\Test\\Helpers\\BaseFactory'] = __DIR__ . '/Test/Helpers/BaseFactory.php';
$classPaths['DataFoundry\\Test\\Helpers\\MapFactory'] = __DIR__ . '/Test/Helpers/MapFactory.php';
$classPaths['DataFoundry\\Test\\Helpers\\DooHickey'] = __DIR__ . '/Test/Helpers/DooHickey.php';

$DataFoundryLoader = function($className) use($classPaths) {
    if (!\array_key_exists($className, $classPaths)) {
        return false;
    }

    return include $classPaths[$className];
};

\spl_autoload_register($DataFoundryLoader);