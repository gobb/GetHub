<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of FactoryTest
 */

namespace GetHub\Test\Cases;

class FactoryTest extends \PHPUnit_Framework_TestCase {

    protected $Factory;

    public function setUp() {
        if (!isset($this->Factory)) {
            $this->Factory = new \GetHub\Test\Helpers\Factory();
        }
    }

    public function testCreatingBasicValidDooHickey() {



    }

}
