<?php

/**
 * @file
 * @brief An abstract class that produces entity objects after mapping the key for
 * data passed to the appropriate class property.
 *
 * @version 1.0.0
 * @since v1.0.0
 */

namespace DataFoundry;

abstract class MapFactory extends \DataFoundry\BaseFactory {

    /**
     * @brief Ensures that the data passed to the entity is mapped to the appropriate
     * keys.
     *
     * @param $name string Java or PHP-style namespaced class to create
     * @param $data array Associative holding data to store
     */
    protected function createEntity($name, array $data) {
        $mappedData = $this->getMappedData($data);
        return parent::createEntity($name, $mappedData);
    }

    /**
     * @param $data array The data that we want to map to the appropriate key.
     */
    protected function getMappedData(array $data) {
        $propertyMap = $this->getPropertyMap();
        $return = array();
        foreach ($propertyMap as $apiKey => $property) {
            if (\array_key_exists($apiKey, $data) && isset($data[$apiKey])) {
                $return[$property] = $data[$apiKey];
            }
        }
        return $return;
    }

    /**
     * @return array Associative array with data key as they key and property for
     * the entity as the value for that key.
     */
    abstract protected function getPropertyMap();

}
