<?php

/**
 * @file
 * @brief Holds a class that stores all the information publicly available about
 * a given github user.
 */

namespace GetHub\Entities;

class User extends \GetHub\Entities\UserStub {

    /**
     * @brief The full name of the user, or at least what they reported to github
     *
     * @property $fullName string
     */
    protected $fullName = '';

    /**
     * @brief A URL for the user's blog as set on their github profile or the URL
     * to github's blog if there is no blog set.
     *
     * @details
     * Please note that while we do our best to ensure that a valid URL is returned
     * from this property we cannot ensure the user input a valid URL in their
     * profile.  As such you should really do some kind of check on this to make
     * sure it really is a URL before you use it in some process that expects a
     * valid URL to be used.
     *
     * @property $blogUrl string
     */
    protected $blogUrl = 'http://github.com/blog';

    /**
     * @brief A timestamp for the datetime the user they created their github
     * account.
     *
     * @details
     * If you need some other format you can use the convenience function located
     * below, getCreatedWithFormat($format).
     *
     * @property $createdAt string
     */
    protected $createdAt = '0000-00-00T00:00:00Z';

    /**
     * @brief An array of GetHub.Entities.RepoStub objects belonging to this user.
     *
     * @property $publicRepoStubs array
     */
    protected $publicRepoStubs = array();

    /**
     * @brief An array of GetHub.Entities.GistStub objects belonging to this user.
     *
     * @property $publicGistStubs array
     */
    protected $publicGistStubs = array();

    /**
     * @brief An array of GetHub.Entities.UserStub objects representing users
     * that follow the created user.
     *
     * @property $followers array
     */
    protected $followers = array();

    /**
     * @brief An array of GetHub.Entiteis.UserStub objects representing users that
     * the created user is following.
     *
     * @property $following array
     */
    protected $following = array();

    /**
     * @brief Whether the created user has set their github profile to be hireable.
     *
     * @property $isHireable boolean
     */
    protected $isHireable = false;

    /**
     * @brief The bio set on the user's github profile.
     *
     * @property $bio string
     */
    protected $bio = '';

    /**
     * @brief The location the user has set on their github profile
     *
     * @property $location string
     */
    protected $location = '';

    /**
     * @brief The email the user has set on their profile, and assuming that the
     * email is actually publicly available.
     *
     * @property $email string
     */
    protected $email = '';

    /**
     * @brief This should be a GetHub.Entities.UserStub null object but it may be
     * a stdClass object if a NullUserStub is not passed in \a $data during construction.
     *
     * @details
     * This is not a key returned by the github API.
     *
     * @property $NullUserStub object
     */
    protected $NullUserStub;

    /**
     * @brief We are overriding the constructor here to ensure that the appropriate
     * NullObjects are set for possible returned stubs.
     *
     * @param $data array Associative data to assign to this entity
     */
    public function __construct(array $data = array()) {
        $this->setNullUserStub($data);
        parent::__construct($data);
        $this->removeRestrictedProperties();
    }

    /**
     * @brief Will ensure that, at the very least, an object is set for the NullUserStub.
     *
     * @param &$data array Associative array that is supposed to be assigned to this user
     */
    protected function setNullUserStub(array &$data) {
        if (\array_key_exists('NullUserStub', $data) && \is_object($data['NullUserStub'])) {
            $this->NullUserStub = $data['NullUserStub'];
            unset($data['NullUserStub']);
        } else {
            // we are doing this because we really want to make sure we return some kind of object
            $this->NullUserStub = new \stdClass();
            $this->NullUserStub->error = 'An expected key, NullUserStub, was not passed from the UserFactory';
        }
    }

    protected function removeRestrictedProperties() {
        unset($this->objectVars['NullUserStub']);
    }

    /**
     * @param $name string The name of the follower to check for this user
     * @return boolean true if the user has a follower with the given name, false if not
     */
    public function hasFollowerByName($name) {
        return $this->groupHasUserStub('followers', 'name', $name);
    }

    /**
     * @param $id int or numeric string Represents the github user id to serach for
     * @return boolean true if the user has a follower with the given id, false if not
     */
    public function hasFollowerById($id) {
        return $this->groupHasUserStub('followers', 'id', (int) $id);
    }

    /**
     * @param $name string The name of the user to see if this user is following
     * @return boolean true if this user is following the user with \a $name or false if they are not
     */
    public function isFollowingByName($name) {
        return $this->groupHasUserStub('following', 'name', $name);
    }

    /**
     * @param $id int or numeric string Represents the gitub user id to search for
     * @return boolean true if the user is following the github user with passed \a $id
     */
    public function isFollowingById($id) {
        return $this->groupHasUserStub('following', 'id', (int) $id);
    }

    /**
     * @param $groupToSearch string Property of this entity holding an array of Stubs to search
     * @param $stubProperty string Name of the stub's property to comapre to
     * @param $compare mixed The value of \a $stubProperty that should match for a true result
     * @return boolean
     */
    protected function groupHasUserStub($groupToSearch, $stubProperty, $compare) {
        foreach ($this->$groupToSearch as $stub) {
            if (!$stub instanceof \GetHub\Entities\UserStub) {
                continue;
            }
            if ($stub->$stubProperty === $compare) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $name string The name of the follower to return the stub for
     * @return GetHub.Entities.UserStub
     */
    public function getFollowerStubByName($name) {
        return $this->getUserStubByProperty('followers', 'name', $name);
    }

    /**
     * @param $id int or numeric string The id of a github user to return a stub for,
     * if they are a follower of this user
     * @return GetHub.Entities.UserStub
     */
    public function getFollowerStubById($id) {
        return $this->getUserStubByProperty('followers', 'id', (int) $id);
    }

    /**
     * @param $name string The name of stub to retrieve for a user this user is following.
     * @return GetHub.Entities.UserStub
     */
    public function getFollowingStubByName($name) {
        return $this->getUserStubByProperty('following', 'name', $name);
    }

    /**
     * @param $id int or numeric string The int of a github user to return a stub for
     * @return GetHub.Entities.UserStub
     */
    public function getFollowingStubById($id) {

    }

    /**
     * @param $groupToGet string The class property, generally followers or following,
     * to search for \a $stubProperty that match \a $compare
     * @param $stubProperty string The property of the stub to check to \a $compare
     * @param $compare mixed The value of \a $stubProperty that should be a positive match
     * @return boolean
     */
    protected function getUserStubByProperty($groupToGet, $stubProperty, $compare) {
        $stub = null;
        foreach ($this->$groupToGet as $groupStub) {
            if (!$groupStub instanceof \GetHub\Entities\UserStub) {
                continue;
            }
            if ($groupStub->$stubProperty === $compare) {
                $stub = $groupStub;
            }
        }
        if (!\is_object($stub)) {
            $stub = $this->NullUserStub;
        }
        return $stub;
    }

}
