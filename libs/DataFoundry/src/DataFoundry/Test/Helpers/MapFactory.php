<?php

/**
 * @file
 * @brief A class to help facilitate the testing of DataFoundry.MapFactory
 */

namespace DataFoundry\Test\Helpers;

class MapFactory extends \DataFoundry\MapFactory {

    /**
     * @return array Associative array to map data key from construct to class property
     */
    protected function getPropertyMap() {
        return array(
            'id' => 'id',
            'login' => 'name',
            'serial_number' => 'serialNumber',
            'parent_doohickey' => 'parentDooHickey'
        );
    }

    /**
     * @return string Java style name this factory should create
     */
    public function getObjectName() {
        return 'DataFoundry.Test.Helpers.DooHickey';
    }

}
