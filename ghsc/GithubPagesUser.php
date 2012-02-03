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
     * @brief The complete HTTP URL for the github pages account for this user
     *
     * @var $websiteUrl string
     */
    protected $websiteUrl;

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

    /**
     * @brief The keys for the array should match up with the properties stored
     * for the user.
     *
     * @param $userData An array of data to store for this user
     */
    public function __construct(array $userData) {
        $this->id = $userData['id'];
        $this->name = $userData['name'];
        $this->repoName = $userData['repoName'];
        $this->apiUrl = $userData['apiUrl'];
        $this->gravatarUrl = $userData['gravatarUrl'];
        $this->websiteUrl = $userData['websiteUrl'];
    }

}
