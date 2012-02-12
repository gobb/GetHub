<?php

/**
 * @file
 * @brief Holds a class that is responsible for creating GetHub.Entities.UserStub
 * objects.
 */

namespace GetHub\Factories;

class UserStubFactory extends \DataFoundry\MapFactory {

    /**
     * @return array Associative array mapping expected github API keys to their
     * appropriate domain keys for a GetHub.Entities.UserStub object.
     */
    protected function getPropertyMap() {
        return array(
            'id' => 'id',
            'login' => 'name',
            'gravatar_id' => 'gravatarId',
            'url' => 'apiUrl'
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
