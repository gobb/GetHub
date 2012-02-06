<?php

/**
 * @file
 * @brief Holds a class used by GetHub data objects to provide some basic functionality
 * and to ensure you can read-only the data.
 */

namespace GetHub;

abstract class Entity implements \IteratorAggregate {

    /**
     * @brief Holds an array of properties for the specific domain object.
     *
     * @details
     * If the property exists in this array it will be returned as if it exists
     * as a property defined by the class.  If you want to add a property to this
     * after Gethub.Entity::__construct() please make sure you add it as a value
     * and not as a key.
     *
     * @property $objectVars array
     */
    protected $objectVars = array();

    public function __construct(array $data) {
        $this->setObjectVars();
        $this->setProperties($data);
    }

    /**
     * @brief Populates \a $this->objectVars with an array of properties held by
     * this Entity.
     */
    protected function setObjectVars() {
        $objectVars = \get_object_vars($this);
        unset($objectVars['objectVars']);
        $this->objectVars = $objectVars;
    }

    /**
     * @brief Will only set the data if the key exists in \a $this->objectVars
     * AND the data has been set.
     *
     * @param $data array Associative with keys mapping to class members
     */
    protected function setProperties(array $data) {
        foreach ($data as $property => $value) {
            if ($this->isProperty($property) && isset($value)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @param $property string The class member holding the data to return
     * @return mixed What is held by \a $property or null if it does not exist
     */
    public function __get($property) {
        if ($this->isProperty($property)) {
            return $this->$property;
        }
        return null;
    }

    /**
     * @param $property string The name of the property to return the value of
     * @return boolean
     */
    public function __isset($property) {
        if ($this->isProperty($property)) {
            return isset($this->$property);
        }
        return false;
    }

    /**
     * @return ArrayIterator Holds values for properties set in \a $this->objectVars
     */
    public function getIterator() {
        $data = array();
        foreach ($this->objectVars as $property => $defaultValue) {
            $data[$property] = $this->$property;
        }
        return new \ArrayIterator($data);
    }

    /**
     * @param $property string Name of the property attempting to destroy
     * @throws DomainException
     */
    public function __unset($property) {
        throw new \DomainException('The property, ' . $property . ', may not be unset.');
    }

    /**
     * @param $property string Name of the property attempting to set
     * @param $value mixed Doesn't matter.  NO SET FOR YOU!
     * @throws DomainException
     */
    public function __set($property, $value) {
        throw new \DomainException('The property, ' . $property . ', may not be set to a new value.');
    }

    protected function isProperty($property) {
        return \array_key_exists($property, $this->objectVars);
    }

}
