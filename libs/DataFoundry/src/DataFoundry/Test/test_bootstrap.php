<?php

// This is a convenience mechanism for testing to get the directory that libs, app
// and web directory is stored in
defined('DATAFOUNDRY_ROOT') or define('DATAFOUNDRY_ROOT', \dirname(\dirname(\dirname(__DIR__))));

include \DATAFOUNDRY_ROOT . '/src/DataFoundry/bootstrap.php';
