<?php

/**
 * @brief An object representing a repository for a githube:pages blog account
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses Entity
 */
class GithubPagesRepo extends Entity {

    /**
     * @brief If there are no branches in a repository the github API returns null,
     * this string is here to ensure we are getting the proper master branch if
     * there is only one branch in the repository.
     *
     * @property DEFAULT_MASTER_BRANCH string
     */
    const DEFAULT_MASTER_BRANCH = 'master';

    /**
     * @brief The name of the repository; translates to GithubPagesUser::repoName
     *
     * @property $name string
     */
    protected $name;

    /**
     * @brief The complete HTTPS URL to query the github API for more information
     * on this repository.
     *
     * @property $apiUrl string
     */
    protected $apiUrl;

    /**
     * @brief The complete HTTP URL to the blog/website that this repository backs
     *
     * @property $websiteUrl string
     */
    protected $websiteUrl;

    /**
     * @property $isPrivate boolean
     */
    protected $isPrivate;

    /**
     * @brief The name of the master branch that holds the repository
     *
     * @var $masterBranch string
     */
    protected $masterBranch;

    public function __construct(array $data) {
        $this->name = $data['name'];
        $this->apiUrl = $data['apiUrl'];
        $this->websiteUrl = $data['websiteUrl'];
        $this->isPrivate = $data['isPrivate'];
        $this->masterBranch = $data['masterBranch'];
    }


}
