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
     * @brief We are passing in a flag for 'https' to toggle the correct protocol,
     * if http is used on an https URL we wil get a 301 response.
     *
     * @param $useHttps String used to flag the use of https over http. Defaults to true
     */
    public function __construct() {
    }

    /**
     * @param $userData An array of data as returned by a github API user request
     * @return GithubPagesUser
     * @see http://developer.github.com/v3/users/
     */
    public function createPagesUser(array $userData) {
        $data = array();
        if (array_key_exists('message', $userData) && $userData['message'] === 'Not Found') {
            $data['id'] = 0;
            $data['name'] = '';
            $data['repoName'] = '';
            $data['gravatarUrl'] = '';
            $data['apiUrl'] = '';
            $data['websiteUrl'] = '';
        } else {
            $data['id'] = $userData['id'];
            $userName = $data['name'] = $userData['login'];
            $data['repoName'] = $userName . '.github.com';
            $data['gravatarUrl'] = 'http://www.gravatar.com/avatar/' . $userData['gravatar_id'];
            $data['apiUrl'] = $userData['url'];
            $data['websiteUrl'] = 'http://' . $data['repoName'];
        }
        return new GithubPagesUser($data);
    }

    public function createPagesRepo(array $repoData) {
        $data = array();
        if (array_key_exists('message', $repoData) && $repoData['message'] === 'Not Found') {
            $data['name'] = '';
            $data['apiUrl'] = '';
            $data['websiteUrl'] = '';
            $data['isPrivate'] = null;
            $data['masterBranch'] = '';
        } else {
            $data['name'] = $repoData['name'];
            $data['apiUrl'] = $repoData['url'];
            $data['websiteUrl'] = $repoData['html_url'];
            $data['isPrivate'] = $repoData['private'];
            $data['masterBranch'] = isset($repoData['master_branch']) ? $repoData['master_branch'] : GithubPagesRepo::DEFAULT_MASTER_BRANCH;
        }
        return new GithubPagesRepo($data);
    }

    /**
     * @param $info Information about a blob post returned from a GithubPagesRepo
     * @return GithubPost
     */
    public function createPost(array $info) {
        $data = array();
        if (array_key_exists('type', $info) && $info['type'] === 'blob') {
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
