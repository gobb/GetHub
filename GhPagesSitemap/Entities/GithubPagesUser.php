<?php

/**
 * @brief An immutable representation of the JSON response returned by github API
 * for a user.
 *
 * @details
 * Please note that if you add a property to this object and you do not also
 * associate the proper API key in GithubEntityFactory that particular property
 * will likely be set to the default values.  Also, please note that this includes
 * keys where the domain and the API match perfectly...THESE STILL NEED TO BE SET!
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
        'gravatarUrl' => 'http://www.gravatar.com/avatar/#',
        'publicRepos' => 0,
        'publicGists' => 0,
        'followers' => 0,
        'following' => 0,
        'repoName' => ''
    );

    /**
     * @property $id int
     */
    protected $id;

    /**
     * @brief The username on github
     *
     * @property $userName string
     */
    protected $name;

    /**
     * @brief The complete HTTPS URL to query the github API for more information about
     * the user.
     *
     * @property $apiUrl string
     */
    protected $apiUrl;

    /**
     * @brief The complete HTTP URL for the github pages account for this user OR
     * whatever is in their github profile under blog; this is expected to be the
     * URL to their github:pages blog of course.
     *
     * @property $blogUrl string
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
     * @property $gravatarUrl string
     */
    protected $gravatarUrl;

    /**
     * @brief The number of public repositories this user has
     *
     * @property $publicRepos int
     */
    protected $publicRepos;

    /**
     * @brief The number of public gists this user has
     *
     * @property $publicGists int
     */
    protected $publicGists;

    /**
     * @brief The number of followers this user has
     *
     * @property $followers int
     */
    protected $followers;

    /**
     * @brief The number of github users this person is following
     *
     * @property $following int
     */
    protected $following;

    /**
     * @brief The name of the repo holding github:pages files
     *
     * @var $pagesRepo string
     */
    protected $repoName;

}
