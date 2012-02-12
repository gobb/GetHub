<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of DataFoundry.MapFactory
 */

namespace DataFoundry\Test\Cases;

class MapFactoryTest extends \PHPUnit_Framework_TestCase {

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
        $this->Factory = new \DataFoundry\Test\Helpers\MapFactory();
    }

    /**
     * @brief Ensures that we can create a DooHickey with some data and that the
     * appropriate DooHickey gets made and mapped to the right properties.
     */
    public function testCreatingBasicValidMappedDooHickey() {
        $object = new \DataFoundry\Test\Helpers\DooHickey(array());
        $data = array(
            'id' => 1,
            'login' => 'cspray',
            'serial_number' => '1234567890',
            'parent_doohickey' => $object
        );
        $Entity = $this->Factory->createObject($data);
        $this->assertSame(1, $Entity->id);
        $this->assertSame('cspray', $Entity->name);
        $this->assertSame('1234567890', $Entity->serialNumber);
        $this->assertSame($object, $Entity->parentDooHickey);
    }

}
