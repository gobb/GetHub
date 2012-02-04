<?php

/**
 * @brief This class will produce objects representing the results from the github
 * API.
 *
 * @author Charles Sprayberry cspray at gmail.com
 */

class GithubEntityFactory {

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

    /**
     * @param $entityName String representing the domain object to create
     * @param $data an associative array with keys matching those in \a $this->defaults
     * @return An Entity object
     */
    public function createGithubEntityObject($entityName, array $data) {
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
    protected function getGithubPagesUserData(array $data) {
        $return = array();
        if ($this->isErrorResponse($data)) {
            return $return;
        }
        $return = $this->getMappedData('pagesUserMap', $data);
        $return['gravatarUrl'] = 'http://www.gravatar.com/avatar/' . $return['gravatarUrl'];
        $return['repoName'] = $return['name'] . '.github.com';
        return $return;
    }

    /**
     * @param $data An associative array representing a response from a github API
     * request for a repository
     * @return array
     */
    protected function getGithubPagesRepoData(array $data) {
        $return = array();
        if ($this->isErrorResponse($data)) {
            return $return;
        }
        $return = $this->getMappedData('pagesRepoMap', $data);
        $owner = (isset($data['owner']) && is_object($data['owner'])) ? $data['owner'] : new stdClass();
        $return['owner'] = $owner;
        if (is_null($return['masterBranch'])) {
            $return['masterBranch'] = GithubPagesRepo::DEFAULT_MASTER_BRANCH;
        }
        return $return;
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
