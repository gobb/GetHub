<?php

/**
 * @brief This class will produce objects representing the results from the github
 * API.
 *
 * @author Charles Sprayberry cspray at gmail.com
 */

class GetHubEntityFactory {

    /**
     * @brief Holds an associative array with the key holding a GithubPagesUser
     * property and the value of that key being the github API response key
     * the property is mapped to; if the data does not come from the API response
     * it does not need to be listed here.
     *
     * @property $pagesUserMap array
     */
    protected $pagesUserMap = array(
        'id' => 'id',
        'name' => 'login',
        'apiUrl' => 'url',
        'blogUrl' => 'blog',
        'profileUrl' => 'html_url',
        'gravatarUrl' => 'gravatar_id',
        'publicRepos' => 'public_repos',
        'publicGists' => 'public_gists',
        'followers' => 'followers',
        'following' => 'following',
    );

    /**
     * @brief Holds an associative array with the key holding a GithubPagesRepo
     * property and the valud of that key being the github API respose key the
     * property is mapped to.
     *
     * @property $pagesRepoMap array
     */
    protected $pagesRepoMap = array(
        'name' => 'name',
        'apiUrl' => 'url',
        'websiteUrl' => 'html_url',
        'isPrivate' => 'private',
        'masterBranch' => 'master_branch'
    );

    protected $pagesPostMap = array(
        'apiUrl' => 'url',
        'path' => 'path'
    );

    /**
     * @brief Throws an exception if the \a $entityName you requested has not
     * been appropriately mapped in this factory by creating a getEntityNameData()
     * method and returning an appropriate associative array from that method.
     *
     * @param $entityName String representing the domain object to create
     * @param $data an associative array with keys matching those in \a $this->defaults
     * @return An Entity object
     * @throws InvalidArgumentException
     */
    public function createGetHubEntityObject($entityName, array $data) {
        $method = 'get' . $entityName . 'Data';
        if (!method_exists($this, $method)) {
            throw new InvalidArgumentException('The entity name you requested does not exist or this factory is not properly setup to create it.');
        }
        $data = call_user_func(array($this, $method), $data);
        return new $entityName($data);
    }

    /**
     * @param $data An associtiave array representing a response from a github API
     * request for a user.
     * @return array
     */
    protected function getGetHubPagesUserData(array $data) {
        $return = array();
        if ($this->isErrorResponse($data)) {
            return $return;
        }
        $return = $this->getMappedData('pagesUserMap', $data);
        $return['gravatarUrl'] = 'http://www.gravatar.com/avatar/' . $return['gravatarUrl'];
        $return['repoName'] = $return['name'] . '.github.com';
        $blogUrl = $return['blogUrl'];
        $http = substr($blogUrl, 0, 7);
        $https = substr($blogUrl, 0, 8);
        if ($http !== 'http://' && $https !== 'https://') {
            $return['blogUrl'] = 'http://' . $blogUrl;
        }
        return $return;
    }

    /**
     * @param $data An associative array representing a response from a github API
     * request for a repository
     * @return array
     */
    protected function getGetHubPagesRepoData(array $data) {
        $return = array();
        if ($this->isErrorResponse($data)) {
            return $return;
        }
        $return = $this->getMappedData('pagesRepoMap', $data);
        if (array_key_exists('owner', $data) && is_object($data['owner'])) {
            $return['owner'] = $data['owner'];
        }
        if (is_null($return['masterBranch'])) {
            $return['masterBranch'] = GetHubPagesRepo::DEFAULT_MASTER_BRANCH;
        }
        return $return;
    }

    protected function getGetHubPagesPostData(array $data) {
        $return = array();
        if ($this->isErrorResponse($data)) {
            return $return;
        }
        $return = $this->getMappedData('pagesPostMap', $data);
        if (array_key_exists('owner', $data) && is_object($data['owner'])) {
            $return['owner'] = $data['owner'];
        } else {
            $return['owner'] = $this->createGithubEntityObject('GithubPagesUser', array());
        }
        $return = $this->massagePostsData($return);
        return $return;
    }

    protected function massagePostsData(array $data) {
        $owner = $data['owner'];
        $path = $this->removeExtensionFromPath($data['path']);
        $info = $this->getPathInfo($owner->blogUrl, $path);
        $data['name'] = $info['name'];
        $data['url'] = $info['url'];
        $data['date'] = $info['date'];
        return $data;
    }

    protected function removeExtensionFromPath($path) {
        $revPath = strrev($path);
        $extPos = strpos($revPath, '.');
        return strrev(substr($revPath, $extPos + 1));
    }

    protected function getPathInfo($prefix, $path) {
        $pathFragments = explode('-', $path);
        $year = array_shift($pathFragments);
        $month = array_shift($pathFragments);
        $day = array_shift($pathFragments);
        $name = implode('-', $pathFragments);
        $url = trim($prefix, '/ ') . '/' . $year . '/' . $month . '/' . $day . '/' . $name;
        $date = $year . '-' . $month . '-' . $day;
        return compact('url', 'date', 'name');
    }

    /**
     * @param $data An array of data returned from a github v3 API query
     * @return boolean
     */
    protected function isErrorResponse(array $data) {
        if (array_key_exists('message', $data) && $data['message'] === 'Not Found') {
            return true;
        }
        return false;
    }

    /**
     * @param $property The property holding the domainKey => apiKey mapping
     * @param $data The data to be mapped
     * @return array of mapped data with value being stored in domainKey properties
     */
    protected function getMappedData($property, array $data) {
        $return = array();
        foreach ($this->$property as $domainKey => $apiKey) {
            if (array_key_exists($apiKey, $data)) {
                $return[$domainKey] = $data[$apiKey];
            }
        }
        return $return;
    }

}
