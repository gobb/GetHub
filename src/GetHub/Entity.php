<?php

/**
 * @file
 * @brief Holds a class used by GetHub data objects to provide some basic functionality
 * and to ensure you can read-only the data.
 */

namespace GetHub;

class Entity {

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
        $this->objectVars = \array_keys($objectVars);
    }

    /**
     * @brief Will only set the data if the key exists in \a $this->objectVars
     * AND the data has been set.
     *
     * @param $data An associative array with keys mapping to class members
     */
    protected function setProperties(array $data) {
        foreach ($data as $property => $value) {
            if (\in_array($property, $this->objectVars) && isset($value)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @param $property The class member holding the data to return
     * @return mixed What is held by \a $property or null if it does not exist
     */
    public function __get($property) {
        if (\in_array($property, $this->objectVars)) {
            return $this->$property;
        }
        return null;
    }

}