<?php

/**
 * @brief Holds a data domain object for posts in a github:pages repository.
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses Entity
 */
class GetHubPagesPost extends GetHubEntity {

    /**
     * @brief The values that should be used if a value is not set in the passed
     * data.
     *
     * @property $defaults array
     */
    protected $defaults = array(
        'url' => '',
        'apiUrl' => 'https://api.github.com',
        'owner' => null,
        'name' => '',
        'date' => ''
    );

    /**
     * @brief The absolute path to the blog post
     *
     * @property $path string
     */
    protected $url;

    /**
     * @brief The complete path to retrieve this page as a blob from github API
     *
     * @property $apiUrl string
     */
    protected $apiUrl;

    /**
     * @brief Will always hold a GetHubPagesUser; may be a NullObject though
     *
     * @property $owner GetHubPagesUser
     */
    protected $owner;

    /**
     * @brief The name of the post without a date
     *
     * @property $name string
     */
    protected $name;

    /**
     * @brief The date of the post in YYYY-MM-DD format.
     *
     * @property $date string
     */
    protected $date;

    public function __construct(array $data) {
        $this->defaults['owner'] = new GetHubPagesUser(array());
        $this->defaults['date'] = date('Y-m-d');
        parent::__construct($data);
    }

}
