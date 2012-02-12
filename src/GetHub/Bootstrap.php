<?php

/**
 * @file
 * @brief Holds a class to setup the library and return the library's API object
 */

namespace GetHub;

/**
 * @brief Will create GetHub objects needed to give you those yummy GetHubEntity
 * objects from the GetHubApi
 *
 * @uses GetHub.ClassLoader
 */
class Bootstrap {

    /**
     * @brief Used as the object holding the autoload callback
     *
     * @property $ClassLoader GetHub.ClassLoader
     */
    protected $ClassLoader;

    /**
     * @brief The big cahuna
     *
     * @property $Api GetHub.Api
     */
    protected $Api;

    /**
     * @brief Will objects that needs to be used by the bootstrap to set everything
     * up.
     */
    public function __construct() {
        $this->makeSureClassLoaderIncluded();
        $this->ClassLoader = new \GetHub\ClassLoader();
    }

    protected function makeSureClassLoaderIncluded() {
        if (!\class_exists('\\GetHub\\ClassLoader')) {
            include __DIR__ . '/ClassLoader.php';
        }
    }

    public function getApi() {
        return $this->Api;
    }

    public function getClassLoader() {
        return $this->ClassLoader;
    }

    /**
     * @brief Is responsible for kicking off the process to generate the GetHubApi
     * object
     *
     * @details
     * The following processes will be completed by this object, in order:
     *
     * - The ClassLoader will be setup to load GetHub classes
     */
    public function runBootstrap() {
        $this->setAutoLoader();
    }

    protected function setAutoLoader() {
        $getHubRoot = __DIR__;
        $libsRoot = \dirname(\dirname($getHubRoot)) . '/libs';
        $dataFoundryRoot = $libsRoot . '/DataFoundry/src';
        $this->ClassLoader->registerNamespaceDirectory('GetHub', $getHubRoot);
        $this->ClassLoader->registerNamespaceDirectory('DataFoundry', $dataFoundryRoot);
        \spl_autoload_register(array($this->ClassLoader, 'load'));
    }

}
