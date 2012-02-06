<?php

/**
 * @file
 * @brief Holds a class responsible for ensuring GetHub.Entity.User objects are
 * created properly.
 */

namespace GetHub\Factories;

class UserFactory extends \GetHub\Factories\UserStubFactory {

    /**
     * @brief An associative array mapping the remaining properties not set by
     * GetHub.Factories.UserStubFactory
     *
     * @property $apiMap array
     */
    protected $apiMap = array(
        'name' => 'fullName',
        'blog' => 'blogUrl',
        'created_at' => 'createdAt',
        'public_repos' => 'publicRepoStubs',
        'public_gists' => 'publicGistStubs',
        'hireable' => 'isHireable',
        'bio' => 'bio',
        'location' => 'location',
        'email' => 'email',
        'following' => 'following',
        'followers' => 'followers',
    );

    /**
     * @brief Note that this overrides the method from UserStubFactory; we will be
     * merging the API map produced by that class with the one produced with this
     * class.
     *
     * @return array Associative holding api -> domain key mappings
     */
    protected function getApiMap() {
        $userStubMap = parent::getApiMap();
        $mergedMap = \array_merge($userStubMap, $this->apiMap);
        return $mergedMap;
    }

    /**
     * @return string Java-style namespaced class this factory produces
     */
    protected function getObjectName() {
        return 'GetHub.Entities.User';
    }

}
