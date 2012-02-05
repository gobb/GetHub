<?php

/**
 * @file
 * @brief Holds a file for a class representing a variety of github user objects
 * that only represents a small selection of data about that user.
 */

namespace GetHub\Entities;

class UserStub extends \GetHub\Entities\GravatarUser {

    /**
     * @brief The numeric github ID for this user
     *
     * @property $id int
     */
    protected $id = 0;

    /**
     * @brief The login for this user
     *
     * @property $name string
     */
    protected $name = '';

    /**
     * @brief The github API URL for this object
     *
     * @property $apiUrl string
     */
    protected $apiUrl = 'https://api.github.com/';

    /**
     * @return string A URL for the user's github profile
     */
    public function getProfileUrl() {
        return 'http://github.com/' . $this->name;
    }

}
