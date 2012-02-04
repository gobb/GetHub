<?php

/**
 * @brief Holds a data domain object for posts in a github:pages repository.
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses Entity
 */
class GithubPagesPost extends Entity {

    /**
     * @brief The relative path to the blog post, does not include any domain or
     * authority before the path.
     *
     * @var $path string
     */
    protected $path;

    /**
     * @brief A 40-digit hash representing the ID for the pages blob
     *
     * @var $sha string
     */
    protected $sha;

    /**
     * @brief The complete path to retrieve this page as a blob from github API
     *
     * @var $apiUrl string
     */
    protected $apiUrl;

    /**
     * @param $data array
     */
    public function __construct(array $data) {
        $this->path = $data['path'];
        $this->sha = $data['sha'];
        $this->apiUrl = $data['apiUrl'];
    }

}
