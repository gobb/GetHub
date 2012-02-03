<?php

/**
 * @brief This class will produce objects representing the results from the github
 * API.
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses GithubUser
 */

class GithubFactory {

    /**
     * @brief The HTTP protocl to use, should either be 'http://' or 'https://'
     *
     * @var $protocol string
     */
    protected $protocol;

    /**
     * @brief We are passing in a flag for 'https' to toggle the correct protocol,
     * if http is used on an https URL we wil get a 301 response.
     *
     * @param $useHttps String used to flag the use of https over http. Defaults to true
     */
    public function __construct($useHttps = true) {
        if ($useHttps) {
            $this->protocol = 'https://';
        } else {
            $this->protocol = 'http://';
        }
    }

    /**
     * @param $userData An array of data as returned by a github API user request
     * @return GithubUser
     * @see http://developer.github.com/v3/users/
     */
    public function createPagesUser(array $userData) {
        $parsedData = array();
        if (\array_key_exists('message', $userData) && $userData['message'] === 'Not Found') {
            $parsedData['userId'] = 0;
            $parsedData['userName'] = '';
            $parsedData['repoName'] = '';
            $parsedData['repoUrl'] = '';
        } else {
            $parsedData['userId'] = $userData['id'];
            $userName = $parsedData['userName'] = $userData['login'];
            $parsedData['repoName'] = $userName . '.github.com';
            $parsedData['repoUrl'] = $this->protocol . 'github.com/' . $userName . '/' . $userName . '.github.com';
        }
        return new GithubPagesUser($parsedData);
    }

    public function createPost(array $info) {
        $data = array();
        if (\array_key_exists('type', $info) && $info['type'] === 'blob') {
            $data['path'] = $info['path'];
            $data['sha'] = $info['sha'];
            $data['apiUrl'] = $info['url'];
        } else {
            $data['path'] = '';
            $data['sha'] = 0;
            $data['apiUrl'] = '';
        }
        return new GithubPost($data);
    }



}
