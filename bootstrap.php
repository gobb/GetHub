<?php


function autoloader($className) {
    $dir = __DIR__;

    $classPaths = array(
        'GetHubEntity' => $dir . '/src/GetHubEntity.php',
        'GetHubPagesApi' => $dir . '/src/GetHubPagesApi.php',
        'GetHubEntityFactory' => $dir . '/src/Entities/GetHubEntityFactory.php',
        'GetHubPagesUser' => $dir . '/src/Entities/GetHubPagesUser.php',
        'GetHubPagesRepo' => $dir . '/src/Entities/GetHubPagesRepo.php',
        'GetHubPagesPost' => $dir . '/src/Entities/GetHubPagesPost.php'
    );

    if (array_key_exists($className, $classPaths)) {
        return include $classPaths[$className];
    }
    return false;
}

spl_autoload_register('autoloader');