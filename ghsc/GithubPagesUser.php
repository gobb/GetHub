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
    protected $userId;

    /**
     * @brief Returned in the 'login' field of the JSON response
     *
     * @var $userName string
     */
    protected $userName;

    /**
     * @brief The name of the repo holding github:pages files
     *
     * @var $pagesRepo string
     */
    protected $repoName;

    /**
     * @brief This is not returned by the response but is created from the results
     * of the response.
     *
     * @var $pagesRepoUrl
     */
    protected $repoUrl;

    /**
     * @brief The keys for the array should match up with the properties stored
     * for the user.
     *
     * @param $userData An array of data to store for this user
     */
    public function __construct(array $userData) {
        $this->userId = $userData['userId'];
        $this->userName = $userData['userName'];
        $this->repoName = $userData['repoName'];
        $this->repoUrl = $userData['repoUrl'];
    }

}
