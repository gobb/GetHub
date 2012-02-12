<?php

/**
 * @file
 * @brief An abstract class that assures only accessible values may be read once
 * data is passed into the object's constructor.
 *
 * @version 1.0.0
 * @since v1.0.0
 */

namespace DataFoundry;

/**
 * @brief Serves as the base read-only data object for DataFoundry v1.0.0.
 *
 * @details
 * It should be noted that the properties used in this class are private as they
 * are absolutely critical to the inner workings of this class and should not be
 * manipulated in anyway whatsoever outside of the exposed API to this class. If
 * the API does not provide exposure of a specific property it means that you are
 * not supposed to mess with it!  Leave it alone!
 *
 * The property names in this class are intentionally prefixed with the vendor name
 * to avoid property name collisions.  We don't want to use up a property name that
 * may be used by an extending class on the internal workings of the data object.
 * It is assumed that only DataFoundry library classes will have properties prefxied
 * with DataFoundry (case-insensitive).
 *
 * @uses IteratorAggregate
 * @uses DomainException
 */
abstract class Entity implements \IteratorAggregate {


    /**
     * @brief Holds an array of all properties stored in this object.
     *
     * @details
     * This is used by the code setting the properties.  This ensure that all properties
     * with values set in the injected constructor data are set; even if those
     * values are inaccessible by the calling code.  We are doing this so that if
     * the domain object needs some data to complete, for example, a helper method
     * but the actual data shouldn't be exposed unaltered there is a way for that
     * data to be set properly.
     *
     * @property $dataFoundryAllProperties array
     */
    private $dataFoundryAllProperties = array();

    /**
     * @brief Holds an array of accessible properties for the specific domain object.
     *
     * @details
     * If the property exists in this array it will be returned as if it exists
     * as a property defined by the class.  The array is associative, with the
     * key being a property and the value being the default set value for that
     * property in the class.  The values stored in this array are not those returned,
     * instead this property simply holds the properties that can be read from
     * outside code; if the property does not exist as a key in this array then
     * attempting to access that property's value from outside the class will result
     * in null being returned.
     *
     * @property $objectVars array
     */
    private $dataFoundryAccessibleProperties = array();

    /**
     * @param $data array Associative with key holding property and value holding
     * the data to store for that property.
     */
    public function __construct(array $data) {
        $this->determineProperties();
        $this->setProperties($data);
    }

    /**
     * @brief Populates \a $this->accessibleProperties with an array of properties
     * held by this Entity that are allowed to be access by outside code.
     */
    protected function determineProperties() {
        $objectVars = \get_object_vars($this);
        $this->dataFoundryAccessibleProperties = $this->dataFoundryAllProperties = $objectVars;
        $this->removeRestrictedProperties();
    }

    /**
     * @brief Removes any restricted properties set by the extending class and
     * will also remove the properties internally used by the DataFoundry.Entity object.
     */
    protected function removeRestrictedProperties() {
        $restricted = $this->getPropertiesToRestrict();
        foreach ($restricted as $restrict) {
            if ($this->isAccessibleProperty($restrict)) {
                unset($this->dataFoundryAccessibleProperties[$restrict]);
            }
        }
    }

    /**
     * @return array An array of properties that should not be accessible.
     */
    protected function getPropertiesToRestrict() {
        $restricted = $this->getRestrictedProperties();
        if (!\is_array($restricted)) {
            $restricted = array();
        }
        $restricted[] = 'dataFoundryAccessibleProperties';
        $restricted[] = 'dataFoundryAllProperties';
        return $restricted;
    }

    /**
     * @brief Will only set the data if the key exists in \a $this->objectVars
     * AND the data has been set.
     *
     * @param $data array Associative with keys mapping to class members
     */
    protected function setProperties(array $data) {
        foreach ($data as $property => $value) {
            if ($this->isExistingProperty($property) && isset($value)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @param $property string The class member holding the data to return
     * @return mixed What is held by \a $property or null if it does not exist
     */
    public function __get($property) {
        if ($this->isAccessibleProperty($property)) {
            return $this->$property;
        }
        return null;
    }

    /**
     * @param $property string The name of the property to return the value of
     * @return boolean
     */
    public function __isset($property) {
        if ($this->isAccessibleProperty($property)) {
            return isset($this->$property);
        }
        return false;
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

    /**
     * @return ArrayIterator Holds values for properties set in \a $this->objectVars
     * to iterate over accessible values
     */
    public function getIterator() {
        $data = array();
        foreach ($this->dataFoundryAccessibleProperties as $property => $defaultValue) {
            $data[$property] = $this->$property;
        }
        return new \ArrayIterator($data);
    }

    /**
     * @brief Checks to see if the given property exists at all and should be set
     *
     * @param $property string The name of the property to check
     * @return boolean
     */
    protected function isExistingProperty($property) {
        return \array_key_exists($property, $this->dataFoundryAllProperties);
    }

    /**
     * @brief Checks to see if the given property is accessible
     *
     * @param $property string The name of the property to check
     * @return boolean
     */
    protected function isAccessibleProperty($property) {
        return \array_key_exists($property, $this->dataFoundryAccessibleProperties);
    }

    /**
     * @return array List of properties that are set but should not be read from.
     */
    abstract protected function getRestrictedProperties();

}
