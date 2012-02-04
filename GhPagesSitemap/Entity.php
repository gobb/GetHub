<?php

/**
 * @brief An abstract class used as the superclass for domain objects.
 *
 * @details
 * tl;dr
 * THIS OBJECT IS READ-ONLY!
 *
 * Please note that this class will only allow properties defined in the class to
 * be set at construction time.  You may not 'overload' properties onto this object,
 * you may not set an existing property to anything after construction, you may not
 * remove a value from this object.
 *
 * @author Charles Sprayberry cspray at gmail.com
 * @uses DomainException
 */
abstract class Entity {

    /**
     * @brief An array of properties allowed to have variables set during construction
     * and are allowed to retrieve from.
     *
     * @var $objectVars array
     */
    protected $objectVars = array();

    /**
     * @brief You should accept an array of data to be stored in this Entity during
     * constructrion; setting values after construction are not allowed.
     *
     * @param $data An array of data
     */
    public function __construct(array $data) {
        $this->setProperties($data);
    }

    /**
     * @param $data associative array with key matching property to set the value to
     */
    protected function setProperties(array $data) {
        $this->objectVars = get_object_vars($this);
        unset($this->objectVars['objectVars']);
        foreach ($this->objectVars as $property => $value) {
            if (array_key_exists($property, $data)) {
                $this->$property = $data[$property];
            }
        }
    }

    /**
     * @param $property string property to retrieve the value of
     * @return mixed; the value stored in \a $property or null
     */
    public function __get($property) {
        if (array_key_exists($property, $this->objectVars)) {
            return $this->$property;
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
        throw new DomainException('Properties for this object may not be set.');
    }

    /**
     * @param $property string property to unset the value of
     * @throws DomainException You may not unset the values of github user data
     */
    public function __unset($property) {
        throw new DomainException('Properties may not be unset for this object.');
    }

}
