<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of FactoryTest
 */

namespace GetHub\Test\Cases;

class FactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @brief The single Factory to produce objects from in this test; ensures that
     * we have a quicker test because we only have to create the Factory once.
     *
     * @property $Factory GetHub.Test.Helpers.Factory
     */
    protected $Factory;

    /**
     * @brief Ensures that \a $this->Factory has a valid object in it.
     */
    public function setUp() {
        if (!isset($this->Factory)) {
            $this->Factory = new \GetHub\Test\Helpers\Factory();
        }
    }

    /**
     * @brief Ensures that we can create a DooHickey with some data and that the
     * appropriate DooHickey gets made.
     */
    public function testCreatingBasicValidDooHickey() {
        $object = new \GetHub\Test\Helpers\DooHickey(array());
        $data = array(
            'id' => 1,
            'serial_number' => '1234567890',
            'login' => 'cspray',
            'parent' => $object
        );
        $DooHickey = $this->Factory->createObject($data);
        $this->assertTrue($DooHickey instanceof \GetHub\Test\Helpers\DooHickey);
        $this->assertSame(1, $DooHickey->id);
        $this->assertSame('1234567890', $DooHickey->serialNumber);
        $this->assertSame('name', 'cspray');
        $this->assertSame('parentDoohickey', $object);
    }

}
