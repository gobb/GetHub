<?php

/**
 * @brief An abstract class used as the superclass for domain objects.
 *
 * @author Charles Sprayberry cspray at gmail.com
 */
abstract class Entity {

    /**
     * @brief An array of variables stored in the entity
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
    abstract public function __construct(array $data);

    /**
     * @param $property string property to retrieve the value of
     * @return mixed; the value stored in \a $property or null
     */
    public function __get($property) {
        if (!$this->objectVars) {
            $this->objectVars = \get_object_vars($this);
            unset($this->objectVars['objectVars']);
        }
        if (\array_key_exists($property, $this->objectVars)) {
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
