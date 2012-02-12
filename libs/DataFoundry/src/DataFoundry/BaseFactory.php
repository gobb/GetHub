<?php

/**
 * @file
 * @brief Holds a class that provides some basic functinality for creating DataFoundry.Entity
 * objects.
 *
 * @version 1.0.0
 * @since v1.0.0
 */

namespace DataFoundry;

abstract class BaseFactory {

    /**
     * @brief Method exposed to calling code to create objects produced by a given
     * Factory
     *
     * @param $data array Associative array of data to store in this object
     * @return object DataFoundry.Entity
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
        return new $class($data);
    }

    /**
     * @param $className A Java-style namespaced class
     * @return string A PHP-style namespaced class
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
     * @return string A Java or PHP-style namespaced class that this Factory should
     * create.
     */
    abstract protected function getObjectName();

}
