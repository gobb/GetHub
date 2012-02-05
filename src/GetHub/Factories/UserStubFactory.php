<?php

/**
 * @file
 * @brief Holds a class that is responsible for creating GetHub.Entities.UserStub
 * objects.
 */

namespace GetHub\Factories;

class UserStubFactory extends \GetHub\Factory {

    /**
     * @return array Associative array mapping expected github API keys to their
     * appropriate domain keys for a GetHub.Entities.UserStub object.
     */
    protected function getApiMap() {
        return array(
            
        );
    }

    /**
     * @return string Java or PHP-style namespaced class that this factory should
     * produce.
     */
    protected function getObjectName() {
        return 'GetHub.Entities.UserStub';
    }

}
