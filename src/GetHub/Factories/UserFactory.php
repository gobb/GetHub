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
        'NullUserStub' => 'NullUserStub'
    );

    /**
     * @brief We are overriding this object so that we may turn repos, gists, following
     * and follower users into the appropriate stubs.
     *
     * @param $data array Associative holding data for this User
     * @return GetHub.Entities.User
     */
    public function createObject(array $data = array()) {
        $data = $this->convertFollowersToUserStubs($data);
        $data = $this->convertFollowingToUserStubs($data);
        $data = $this->addNullUserStub($data);
        return parent::createObject($data);
    }

    /**
     * @param $data array An array of data to be stored in a GetHub.Entities.UserStub
     * @return GetHub.Entities.UserStub
     */
    public function createStub(array $data) {
        return parent::createEntity(parent::getObjectName(), $data);
    }

    /**
     * @param $data array Associative that may or may not have a key followers.
     * @return array of GetHub.Entities.UserStub objects or an empty array
     */
    protected function convertFollowersToUserStubs(array $data) {
        if (empty($data)) {
            return $data;
        }
        $followers = (\array_key_exists('followers', $data)) ? $data['followers'] : array();
        $followerStubs = $this->getUserStubs($followers);
        $data['followers'] = $followerStubs;
        return $data;
    }

    /**
     * @param $data array Associative array that may or may not have a key following.
     * @return array of GetHub.Entities.UserStub objects or an empty array
     */
    protected function convertFollowingToUserStubs(array $data) {
        if (empty($data)) {
            return $data;
        }
        $following = (\array_key_exists('following', $data)) ? $data['following'] : array();
        $followingStubs = $this->getUserStubs($following);
        $data['following'] = $followingStubs;
        return $data;
    }

    /**
     * @brief Ensures that we get a NullObject for user stub calls in GetHub.Entities.User
     *
     * @param $data array response from github API
     * @return array with NullUserStub key added
     */
    protected function addNullUserStub(array $data) {
        $data['NullUserStub'] = $this->createStub(array());
        return $data;
    }

    /**
     *
     * @param $followers array An array of follower array data
     * @return array of GetHub.Entities.UserStub objects or an empty array if there
     * are not followers.
     */
    protected function getUserStubs(array $stubData) {
        $stubs = array();
        foreach ($stubData as $stub) {
            if (\is_array($stub)) {
                $stubs[] = $this->createStub($stub);
            }
        }
        return $stubs;
    }

    /**
     * @brief Note that this overrides the method from UserStubFactory; we will be
     * merging the API map produced by that class with the one produced with this
     * class.
     *
     * @return array Associative holding api -> domain key mappings
     */
    protected function getApiMap() {
        $userStubMap = parent::getApiMap();
        return \array_merge($userStubMap, $this->apiMap);
    }

    /**
     * @return string Java-style namespaced class this factory produces
     */
    protected function getObjectName() {
        return 'GetHub.Entities.User';
    }

}
