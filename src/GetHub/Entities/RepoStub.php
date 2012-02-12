<?php

/**
 * @file
 * @brief A data object representing repository information returned from a request
 * for a list of user's or organization repositories.
 */

namespace GetHub\Entities;

class RepoStub extends \DataFoundry\Entity {

    /**
     * @brief The github API URL for this object
     *
     * @property $apiUrl string
     */
    protected $apiUrl = 'https://api.github.com/';

    /**
     * @brief The URL for the repo's github page
     *
     * @property $websiteUrl string
     */
    protected $websiteUrl = 'http://github.com/github/developer.github.com';

    /**
     * @brief The URL to clone the git repository from github
     *
     * @property $gitCloneUrl string
     */
    protected $gitCloneUrl = 'git://github.com/github/developer.github.com.git';

    /**
     * @brief A UserStub representing the owner of this repository
     *
     * @property $owner GetHub.Entities.UserStub
     */
    protected $owner;

    /**
     * @brief The name of the repository
     *
     * @property $name string
     */
    protected $name = '';

    /**
     * @brief The description of the repository as set on the github page for that
     * repo.
     *
     * @property $description string
     */
    protected $description = '';

    /**
     * @brief The language set for the repository.
     *
     * @property $language string
     */
    protected $language = '';

    /**
     * @brief Whether or not the repository is private or public
     *
     * @property $isPrivate boolean
     */
    protected $isPrivate = false;

    /**
     * @brief Whether or not the repository is a fork of another repository
     *
     * @property $isFork boolean
     */
    protected $isFork = false;

    /**
     * @brief The number of times this repository has been forked by others.
     *
     * @property $numberOfTimesForked int
     */
    protected $numberOfTimesForked = 0;

    /**
     * @property $numberOfWatchers int
     */
    protected $numberOfWatchers = 0;

    /**
     * @var $masterBranch string
     */
    protected $masterBranch = 'master';

    /**
     * @property $openIssues int
     */
    protected $numberOfOpenIssues = 0;

    /**
     * @brief The last time this repository was pushed to.
     *
     * @property $pushedAt string
     */
    protected $pushedAt = '0000-00-00T00:00:00';

    /**
     * @brief The date the repository was created
     *
     * @property $createdAt string
     */
    protected $createdAt = '0000-00-00T00:00:00';

    /**
     * @return array Numeric index array of properties to not allow access to
     */
    protected function getRestrictedProperties() {
        return array();
    }

}
