<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of FactoryTest
 */

namespace DataFoundry\Test\Cases;

class BaseFactoryTest extends \PHPUnit_Framework_TestCase {

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
        $this->Factory = new \DataFoundry\Test\Helpers\BaseFactory();
    }

    /**
     * @brief Ensures that we can create a DooHickey with some data and that the
     * appropriate DooHickey gets made and mapped to the right properties.
     */
    public function testCreatingBasicValidDooHickey() {
        $object = new \DataFoundry\Test\Helpers\DooHickey(array());
        $data = array(
            'id' => 1,
            'serialNumber' => '1234567890',
            'name' => 'cspray',
            'parentDooHickey' => $object
        );
        $DooHickey = $this->Factory->createObject($data);
        $this->assertInstanceOf('\\DataFoundry\\Test\\Helpers\\DooHickey', $DooHickey);
        $this->assertSame(1, $DooHickey->id);
        $this->assertSame('1234567890', $DooHickey->serialNumber);
        $this->assertSame('cspray', $DooHickey->name);
        $this->assertSame($object, $DooHickey->parentDooHickey);
        $this->assertNull($DooHickey->objectVars);
    }

    /**
     * @brief Ensures that the Factory is producing the appropriate NullObject if
     * no data is passed.
     */
    public function testCreatingNullDooHickey() {
        $DooHickey = $this->Factory->createObject();
        $this->assertSame(0, $DooHickey->id);
        $this->assertSame('0000000000', $DooHickey->serialNumber);
        $this->assertSame('Thinga-Ma-Bob', $DooHickey->name);
        $this->assertInstanceOf('stdClass', $DooHickey->parentDooHickey);
    }

}
