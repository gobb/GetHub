<?php

/**
 * @brief An immutable representation of the JSON response returned by github API
 * for a user.
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses DomainException
 * @see GithubFactory
 */
class GithubUser {

    /**
     * @brief Returned in the 'id' field of the JSON response
     *
     * @var $id int
     */
    protected $id;

    /**
     * @brief Returned in the 'login' field of the JSON response
     *
     * @var $userName string
     */
    protected $userName;

    /**
     * @brief The name of the repo holding github:pages files
     *
     * @var $pagesRepo string
     */
    protected $pagesRepo;

    /**
     * @brief This is not returned by the response but is created from the results
     * of the response.
     *
     * @var $pagesRepoUrl
     */
    protected $pagesRepoUrl;

    /**
     * @brief Holds an array of data pertaining to the user; we have this here
     * so we only need to call get_object_vars() once.
     *
     * @var $objectVars array
     */
    protected $objectVars;

    /**
     * @brief The keys for the array should match up with the properties stored
     * for the user.
     *
     * @param $userData An array of data to store for this user
     */
    public function __construct(array $userData) {
        $this->id = $userData['id'];
        $this->userName = $userData['userName'];
        $this->pagesRepo = $userData['pagesRepo'];
        $this->pagesRepoUrl = $userData['pagesRepoUrl'];
    }

    /**
     * @param $property string property to retrieve the value of
     * @return mixed; the value stored in \a $property or null
     */
    public function __get($property) {
        if (!$this->objectVars) {
            $this->objectVars = \get_object_vars($this);
        }
        if (\array_key_exists($property, $this->objectVars) && $property !== 'objectVars') {
            return $this->objectVars[$property];
        }
        return null;
    }

    /**
     * @param $property string representing class property to check if value has been set
     * @return true if the value has been set, false if not
     */
    public function __isset($property) {
        return isset($this->$property);
    }

    /**
     * @param $property string property to set the \a value of
     * @param $value mixed data to set to \a $property
     * @throws DomainException You may not set the values of github user data
     */
    public function __set($property, $value) {
        throw new \DomainException('Properties for this object may not be set.');
    }

    /**
     * @param $property string property to unset the value of
     * @throws DomainException You may not unset the values of github user data
     */
    public function __unset($property) {
        throw new \DomainException('Properties may not be unset for this object.');
    }

}
