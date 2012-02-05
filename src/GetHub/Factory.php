<?php

/**
 * @file
 * @brief Holds a class that provides some basic functinality for creating GetHub.Entity
 * objects.
 */

namespace GetHub;

abstract class Factory {

    /**
     * @brief Method exposed to calling code to create objects produced by a given
     * Factory
     *
     * @param $data array Associative array of data to store in this object
     * @return object GetHub.Entity
     */
    public function createObject(array $data = array()) {
        return $this->createEntity($this->getObjectName(), $data);
    }

    /**
     * @param $name string The name of the class to create
     * @param $data array A list of data to create for this entity
     */
    protected function createEntity($name, array $data) {
        $class = $this->convertJavaClassToPhpClass($name);
        $mappedData = $this->getMappedData($data);
        return new $class($mappedData);
    }

    /**
     * @param $apiMap array Associative holding map for github API -> GetHub domain.
     * @param $data array Associative returned from github API.
     * @return array Associative of data with GetHub domain key and the value returned
     * from github API.
     */
    protected function getMappedData(array $data) {
        $mappedData = array();
        $apiMap = $this->getApiMap();
        foreach ($apiMap as $apiKey => $domainKey) {
            if (\array_key_exists($apiKey, $data)) {
                $mappedData[$domainKey] = $data[$apiKey];
            }
        }
        return $mappedData;
    }

    /**
     * @param $className A Java-style namespaced class
     * @return A PHP-style namespaced class
     */
    protected function convertJavaClassToPhpClass($className) {
        if (!\is_string($className)) {
            return $className;
        }

        $backSlash = '\\';
        $dot = '.';
        if (\strpos($className, $dot) !== false) {
            $className = \str_replace($dot, $backSlash, $className);
        }
        return $backSlash . \trim($className, '\\ ');
    }

    /**
     * @return array Associative with key matching key returned from github API and
     * the value of that key being the name of the domain property for that object.
     */
    abstract protected function getApiMap();

    /**
     * @return string A Java or PHP-style namespaced class that this Factory should
     * create.
     */
    abstract protected function getObjectName();

}
