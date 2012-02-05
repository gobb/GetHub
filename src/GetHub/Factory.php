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
     * @return GetHub.Entity object
     */
    public function createObject(array $data = array()) {

    }

    /**
     * @param $name string The name of the class to create
     * @param $data array A list of data to create for this entity
     */
    protected function createEntity($name, array $data) {

    }

    /**
     * @return array Associative with key matching key returned from github API and
     * the value of that key being the name of the domain property for that object.
     */
    abstract protected function getApiMap();

    /**
     * @return object An object that should be used as the return type when an
     * error is occurred creating the requested object.
     */
    abstract protected function getNullObject();

}
