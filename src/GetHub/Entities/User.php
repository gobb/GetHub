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
     * @param $name string The name of the follower to check for this user
     */
    public function hasFollowerByName($name) {

    }

}
