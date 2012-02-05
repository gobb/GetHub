<?php

/**
 * @file
 * @brief Holds a class that is returned by GetHub.Test.Helpers.Factory
 */

namespace GetHub\Test\Helpers;

class DooHickey extends \GetHub\Entity {

    protected $id = 0;

    protected $serialNumber = '0000000';

    protected $name = 'Thinga-Ma-Bob';

    protected $parentDoohickey;

    public function __construct(array $data) {
        $this->parentDoohickey = new self(array());
        parent::__construct($data);
    }

}
