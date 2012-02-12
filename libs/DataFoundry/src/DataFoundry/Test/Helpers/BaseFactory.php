<?php

/**
 * @file
 * @brief Holds a class used by unit tests to ensure the functionality for the
 * base DataFoundry.BaseFactory object.
 */

namespace DataFoundry\Test\Helpers;

class BaseFactory extends \DataFoundry\BaseFactory {

    /**
     * @return string The Java or PHP-style namespaced class that this Factory
     * should create.
     */
    protected function getObjectName() {
        return 'DataFoundry.Test.Helpers.DooHickey';
    }

}
