<?php


function autoloader($className) {
    $dir = __DIR__;

    $classPaths = array(
        'Entity' => $dir . '/Entity.php',
        'GithubApi' => $dir . '/GithubApi.php',
        'GithubFactory' => $dir . '/GithubFactory.php',
        'GithubPagesUser' => $dir . '/Entities/GithubPagesUser.php',
        'GithubPagesRepo' => $dir . '/Entities/GithubPagesRepo.php'
    );

    if (array_key_exists($className, $classPaths)) {
        return include $classPaths[$className];
    }
    return false;
}

spl_autoload_register('autoloader');