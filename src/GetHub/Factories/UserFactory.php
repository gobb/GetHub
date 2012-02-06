<?php

/**
 * @file
 * @brief Holds a class responsible for ensuring GetHub.Entity.User objects are
 * created properly.
 */

namespace GetHub\Factories;

class UserFactory extends \GetHub\Factories\UserStubFactory {

    /**
     * @brief The Factory used to create followers and the people this user is
     * following.
     *
     * @property $UserStubFactory GetHub.Factories.UserStubFactory
     */
    protected $UserStubFactory;

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
     * @param $UserStubFactory GetHub.Factories.UserStubFactory
     */
    public function __construct(\GetHub\Factories\UserStubFactory $UserStubFactory) {
        $this->UserStubFactory = $UserStubFactory;
    }

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
        return parent::createObject($data);
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
     *
     * @param $followers array An array of follower array data
     * @return array of GetHub.Entities.UserStub objects or an empty array if there
     * are not followers.
     */
    protected function getUserStubs(array $stubData) {
        $stubs = array();
        foreach ($stubData as $stub) {
            if (\is_array($stub)) {
                $stubs[] = $this->UserStubFactory->createObject($stub);
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
