<?php

/**
 * @brief This class is responsible for querying the github API to retrieve the
 * data about a particular repository.
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses GithubFactory
 */
class GetHubPagesApi {

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
    public function __construct(GetHubEntityFactory $GhFactory) {
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
        return $this->createGetHubPagesUser($request);
    }

    /**
     * @brief Will return a GithubPagesRepo object holding the information for the
     * \a $User github:pages repository.
     *
     * @param $User GithubPagesUser
     * @return GithubPagesRepo
     */
    public function getPagesRepo(GetHubPagesUser $User) {
        $url = $this->apiUrl . 'repos/' . $User->name . '/' . $User->repoName;
        $request = $this->executeRequest($url);
        $request['owner'] = $User;
        return $this->createGetHubPagesRepo($request);
    }

    /**
     * @param GithubPagesRepo $Repo
     * @return An array of GithubPagesPost objects
     */
    public function getPosts(GetHubPagesRepo $Repo) {
        $sha = $this->getMasterBranchSha($Repo);
        $tree = $this->getTree($Repo, $sha);
        $sha = $this->getPostsSha($tree);
        $tree = $this->getTree($Repo, $sha);
        $blobShas = $this->getBlobData($Repo->owner, $tree);
        $posts = $this->getCollectionOfPosts($Repo, $blobShas);
        return $posts;
    }

    /**
     * @param $Repo GithubPagesRepo to retrieve a tree from
     * @param $sha The hash for the tree to retrieve
     * @return array
     */
    protected function getTree(GetHubPagesRepo $Repo, $sha) {
        $url = $this->apiUrl . 'repos/' . $Repo->owner->name . '/' . $Repo->name . '/git/trees/' . $sha;
        return $this->executeRequest($url);
    }

    /**
     * @param $Repo GithubPagesRepo The repository to get data from
     * @return mixed A string for the latest commit in the master branch
     */
    protected function getMasterBranchSha(GetHubPagesRepo $Repo) {
        $url = $this->apiUrl . 'repos/' . $Repo->owner->name . '/' . $Repo->name . '/branches';
        $request = $this->executeRequest($url);
        foreach($request as $branch) {
            if ($branch['name'] === $Repo->masterBranch) {
                return $branch['commit']['sha'];
            }
        }
        return 0;
    }

    /**
     * @param $tree A tree of master branch data to retrieve the sha for the `_posts`
     * tree
     * @return mixed A string for the latest commit to the `_posts` directory
     */
    protected function getPostsSha(array $tree) {
        if (array_key_exists('message', $tree) && $tree['message'] === 'Not Found') {
            return 0;
        }
        foreach ($tree['tree'] as $blobData) {
            if ($blobData['path'] === '_posts') {
                return $blobData['sha'];
            }
        }
    }

    /**
     * @brief The data returned form this will utlimately be used to create the
     * appropriate posts object
     *
     * @param $tree The tree to get all blob data for
     * @return array
     */
    protected function getBlobData(GetHubPagesUser $Owner, array $tree) {
        $return = array();
        if (array_key_exists('message', $tree) && $tree['message'] === 'Not Found') {
            return $return;
        }
        foreach ($tree['tree'] as $blobData) {
            if ($blobData['type'] === 'blob') {
                $index = count($return);
                $return[$index] = array();
                $return[$index]['owner'] = $Owner;
                $return[$index]['url'] = $blobData['url'];
                $return[$index]['path'] = $blobData['path'];
            }
        }
        return $return;
    }

    /**
     * @param $Repo GithubPagesRepo
     * @param $blobData Array of data returned from getBlobData()
     * @return array of GithubPagesPost objects
     */
    protected function getCollectionOfPosts(GetHubPagesRepo $Repo, array $blobData) {
        $return = array();
        if (empty($blobData)) {
            return $return;
        }
        foreach ($blobData as $data) {
            $return[] = $this->createGetHubPagesPost($data);

        }
        return $return;
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
    protected function createGetHubPagesUser(array $userData) {
        return $this->Factory->createGetHubEntityObject('GetHubPagesUser', $userData);
    }

    /**
     * @param $repoData An array of data about a given github:pages repository
     * @return GithubPagesRepo
     */
    protected function createGetHubPagesRepo(array $repoData) {
        return $this->Factory->createGetHubEntityObject('GetHubPagesRepo', $repoData);
    }

    /**
     *
     * @param $postData An array of data about a given github:pages post
     * @return GithubPagesPost
     */
    protected function createGetHubPagesPost(array $postData) {
        return $this->Factory->createGetHubEntityObject('GetHubPagesPost', $postData);
    }

}
