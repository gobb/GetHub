<?php

/**
 * @file
 * @brief Holds a class that provides some basic functinality for creating GetHub.Entity
 * objects.
 */

namespace GetHub;

abstract class Factory {

    /**
     *
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
