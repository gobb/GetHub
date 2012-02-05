<?php

// This is a convenience mechanism for testing to get the directory that libs, app
// and web directory is stored in
defined('GETHUB_ROOT') or define('GETHUB_ROOT', \dirname(\dirname(\dirname(__DIR__))));

include \GETHUB_ROOT . '/src/GetHub/ClassLoader.php';
$ClassLoader = new \GetHub\ClassLoader();
$ClassLoader->registerNamespaceDirectory('GetHub', \GETHUB_ROOT . '/src');
\spl_autoload_register(array($ClassLoader, 'load'));