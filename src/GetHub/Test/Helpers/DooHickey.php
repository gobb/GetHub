<?php

/**
 * @file
 * @brief Holds a class that is returned by GetHub.Test.Helpers.Factory
 */

namespace GetHub\Test\Helpers;

class DooHickey extends \GetHub\Entity {

    protected $id = 0;

    protected $serialNumber = '0000000000';

    protected $name = 'Thinga-Ma-Bob';

    protected $parentDooHickey;

    public function __construct(array $data) {
        $this->parentDooHickey = new \stdClass();
        parent::__construct($data);
    }

}
