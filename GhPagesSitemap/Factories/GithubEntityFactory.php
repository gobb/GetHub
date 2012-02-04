<?php

/**
 * @brief This class will produce objects representing the results from the github
 * API.
 *
 * @author Charles Sprayberry cspray at gmail.com
 */

abstract class GithubEntityFactory {

    /**
     * @brief An associative array listing the values that should be used for a
     * default or 'NullObject' entity.
     *
     * @details
     * Note that this is here as a convenience.  As long as your implementation of
     * GithubEntityFactory properly returns an associative array with valid keys
     * from getDefaultData() then you can implement this however you want.
     *
     * @property $defaults array
     */
    protected $defaults = array();

    /**
     * @brief The name of the GithubPages* or Github* objects to create.
     *
     * @property $entityName string
     */
    protected $entityName;

    /**
     * @brief We are passing in a flag for 'https' to toggle the correct protocol,
     * if http is used on an https URL we wil get a 301 response.
     *
     * @param $useHttps String used to flag the use of https over http. Defaults to true
     */
    public function __construct($entityName) {
        $this->entityName = $entityName;
    }

    /**
     * @param $data an associative array with keys matching those in \a $this->defaults
     * @return An Entity object
     */
    protected function createGithubEntityObject(array $data) {
        $defaults = $this->getDefaultData();
        $arbitraryData = array_merge($defaults, $data);
        $restrictedData = array();
        foreach($this->defaults as $key => $value) {
            $restrictedData[$key] = $arbitraryData[$key];
        }
        return new $this->entityName($restrictedData);
    }

    abstract protected function getDefaultData();

}
