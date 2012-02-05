<?php

/**
 * @file
 * @brief Holds a class used by unit tests to ensure the functionality for the
 * base GetHub.Factory object.
 */

namespace GetHub\Test\Helpers;

class Factory extends \GetHub\Factory {

    /**
     * @brief This method is required by the GetHub.Factory class
     *
     * @return array Associative with github API keys as the key and the GetHub
     * data object key as the value.
     */
    protected function getApiMap() {

    }

    /**
     * @brief This method is required by the GetHub.Factory class
     *
     * @return object An empty or null object for whatever class this Factory is
     * producing.
     */
    protected function getNullObject() {

    }


}
