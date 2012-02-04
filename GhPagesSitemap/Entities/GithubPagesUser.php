<?php

/**
 * @brief An immutable representation of the JSON response returned by github API
 * for a user.
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses Entity
 */
class GithubPagesUser extends Entity {

    /**
     * @brief An associative array holding values to be used for a 'NullObject' or
     * if a particular property is not set in the passed constructor array
     *
     * @property $defaults array
     */
    protected $defaults = array(
        'id' => 0,
        'name' => 'github',
        'apiUrl' => 'https://api.github.com',
        'blogUrl' => 'https://github.com/blog',
        'profileUrl' => 'https://github.com/github',
        'gravatarUrl' => 'http://www.gravatar/avatar/',
        'repoName' => ''
    );

    /**
     * @brief Returned in the 'id' field of the JSON response
     *
     * @var $id int
     */
    protected $id;

    /**
     * @brief Returned in the 'login' field of the JSON response
     *
     * @var $userName string
     */
    protected $name;

    /**
     * @brief The complete HTTPS URL to query the github API for more information about
     * the user.
     *
     * @var $apiUrl string
     */
    protected $apiUrl;

    /**
     * @brief The complete HTTP URL for the github pages account for this user OR
     * whatever is in their github profile under blog; this is expected to be the
     * URL to their github:pages blog of course.
     *
     * @var $blogUrl string
     */
    protected $blogUrl;

    /**
     * @brief The complete
     *
     * @property $profileUrl string
     */
    protected $profileUrl;

    /**
     * @brief The complete path to the user's gravatar
     *
     * @var $gravatarUrl string
     */
    protected $gravatarUrl;

    /**
     * @brief The name of the repo holding github:pages files
     *
     * @var $pagesRepo string
     */
    protected $repoName;

}
