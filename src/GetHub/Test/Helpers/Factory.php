<?php

/**
 * @file
 * @brief Holds a class used by unit tests to ensure the functionality for the
 * base GetHub.Factory object.
 */

namespace GetHub\Test\Helpers;

class Factory extends \GetHub\Factory {

    protected $apiMap = array(
        'id' => 'id',
        'serial_number' => 'serialNumber',
        'login' => 'name',
        'parent' => 'parentDooHickey'
    );

    /**
     * @brief This method is required by the GetHub.Factory class
     *
     * @return array Associative with github API keys as the key and the GetHub
     * data object key as the value.
     */
    protected function getApiMap() {
        return $this->apiMap;
    }

    /**
     * @return string The Java or PHP-style namespaced class that this Factory
     * should create.
     */
    protected function getObjectName() {
        return 'GetHub.Test.Helpers.DooHickey';
    }


}
