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
    public function createUser(array $userData) {
        $parsedData = array();
        if (\array_key_exists('message', $userData) && $userData['message'] === 'Not Found') {
            $parsedData['id'] = 0;
            $parsedData['userName'] = '';
            $parsedData['pagesRepo'] = '';
            $parsedData['pagesRepoUrl'] = '';
        } else {
            $parsedData['id'] = $userData['id'];
            $userName = $parsedData['userName'] = $userData['login'];
            $parsedData['pagesRepo'] = $userName . '.github.com';
            $parsedData['pagesRepoUrl'] = $this->protocol . 'github.com/' . $userName . '/' . $userName . '.github.com';
        }
        return new GithubUser($parsedData);
    }

}
