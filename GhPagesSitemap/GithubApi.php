<?php

/**
 * @brief This class is responsible for querying the github API to retrieve the
 * data about a particular repository.
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses GithubFactory
 */
class GithubApi {

    /**
     * @brief Holds a factory used to create various objects representing the response
     * from the github API.
     *
     * @var $Factory GithubFactory
     */
    protected $Factory;

    /**
     * @brief Holds the resource used to query the github API
     *
     * @var $curl cURL resource
     */
    protected $curl;

    /**
     * @brief Holds the base URL for all API requests
     *
     * @var $apiUrl string
     */
    protected $apiUrl = 'https://api.github.com/';

    /**
     * @brief A flag used to determine if the default cURL options should be set
     * before executing a request.
     *
     * @var $defaultOptionsSet boolean
     */
    protected $defaultOptionsSet = false;

    /**
     * @param $GhFactory GithubFactory
     */
    public function __construct(GithubEntityFactory $GhFactory) {
        $this->curl = curl_init();
        $this->Factory = $GhFactory;
    }

    /**
     * @param $userName string representing your github username
     * @return GithubPagesUser
     */
    public function getUser($userName) {
        $url = $this->apiUrl . 'users/' . $userName;
        $request = $this->executeRequest($url);
        return $this->createGithubPagesUser($request);
    }

    /**
     * @brief
     *
     * @param $User GithubPagesUser
     * @return GithubPagesRepo
     */
    public function getPagesRepo(GithubPagesUser $User) {
        $url = $this->apiUrl . 'repos/' . $User->name . '/' . $User->repoName;
        $request = $this->executeRequest($url);
        $request['owner'] = $User;
        return $this->createGithubPagesRepo($request);
    }

    /**
     * @param $url The URL to send via cURL
     * @return array of decoded JSON data
     */
    protected function executeRequest($url) {
        if (!$this->defaultOptionsSet) {
            $this->setDefaultCurlOptions();
        }
        $this->setUrl($url);
        $response = curl_exec($this->curl);
        return json_decode($response, true);
    }

    /**
     * @brief Set the HTTP request method to GET, ensures the data is transferred
     * instead of displayed and ensure that we do not follow any location sent
     * by the response.
     */
    protected function setDefaultCurlOptions() {
        curl_setopt($this->curl, CURLOPT_HTTPGET, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
    }

    /**
     * @param $url The complete URL to query with cURL
     */
    protected function setUrl($url) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
    }

    /**
     * @param $userData An array of data about a given github:pages user
     * @return GithubPagesUser
     */
    protected function createGithubPagesUser(array $userData) {
        return $this->Factory->createGithubEntityObject('GithubPagesUser', $userData);
    }

    protected function createGithubPagesRepo(array $repoData) {
        return $this->Factory->createGithubEntityObject('GithubPagesRepo', $repoData);
    }

}
