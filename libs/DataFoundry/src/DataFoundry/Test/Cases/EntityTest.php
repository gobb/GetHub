<?php

/**
 * @file
 * @brief Holds a file that tests the basic functionality of a DataFoundry.Entity
 * object
 */

namespace DataFoundry\Test\Cases;

class EntityTest extends \PHPUnit_Framework_TestCase {

    /**
     * @brief Assures that a basic entity can be created and the properties can
     * be accessed with the appropriate values being stored.
     */
    public function testBasicEntityCreation() {
        $data = array(
            'id' => 1,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/',
            'anObject' => null
        );
        $Entity = new \DataFoundry\Test\Helpers\Entity($data);
        $this->assertSame(1, $Entity->id);
        $this->assertSame('cspray', $Entity->name);
        $this->assertSame('https://api.github.com/', $Entity->apiUrl);
        $this->assertSame('stdClass',  \get_class($Entity->anObject));
        $this->assertInstanceOf('stdClass', $Entity->anObject);
    }

    /**
     * @brief Making sure that we can properly cast isset on objects and we get
     * an appropriate response.
     */
    public function testIssetOnEntityProperties() {
        $data = array(
            'id' => null,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/',
            'anObject' => null
        );
        $Entity = new \DataFoundry\Test\Helpers\Entity($data);
        $this->assertTrue(isset($Entity->id), 'Entity::id is not set.');
        $this->assertTrue(isset($Entity->name), 'Entity::name is not set.');
        $this->assertTrue(isset($Entity->apiUrl), 'Entity::apiUrl is not set.');
        $this->assertTrue(isset($Entity->anObject), 'Entity::anObject is not set.');
        $this->assertFalse(isset($Entity->doNotExist), 'Entity::doNotExist is set.');
    }

    /**
     * @brief Making sure that entity properties cannot be unset
     */
    public function testUnsetOnEntityProperties() {
        $data = array(
            'id' => 1,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/',
            'anObject' => null
        );
        $Entity = new \DataFoundry\Test\Helpers\Entity($data);
        $exceptionThrown = false;
        try {
            unset($Entity->id);
        } catch(\DomainException $DomainException) {
            $exceptionThrown = true;
            $this->assertSame('The property, id, may not be unset.', $DomainException->getMessage());
        }
        $this->assertTrue($exceptionThrown, 'An expected exception was not thrown.');
    }

    /**
     * @brief Testing that you cannot set the property of an object
     */
    public function testSettingAnEntityProperty() {
        $data = array(
            'id' => 1,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/',
            'anObject' => null
        );
        $Entity = new \DataFoundry\Test\Helpers\Entity($data);
        $exceptionThrown = false;
        try {
            $Entity->name = 'GetHub';
        } catch(\DomainException $DomainException) {
            $exceptionThrown = true;
            $this->assertSame('The property, name, may not be set to a new value.', $DomainException->getMessage());
        }
        $this->assertTrue($exceptionThrown);
    }

    /**
     * @brief Makes sure that if an empty array is passed a NullObject is propertly
     * returned with the default values.
     */
    public function testSettingNullProperties() {
        $Entity = new \DataFoundry\Test\Helpers\Entity(array('id' => null));
        $this->assertSame(0, $Entity->id);
        $this->assertSame('gethubocat', $Entity->name);
        $this->assertSame('https://cspray.github.com/api/', $Entity->apiUrl);
        $this->assertInstanceOf('stdClass', $Entity->anObject);
    }

    /**
     * @brief Will test that an entity can be looped over
     */
    public function testLoopingOverEntity() {
        $data = array(
            'id' => 1,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/',
            'anObject' => null
        );
        $Entity = new \DataFoundry\Test\Helpers\Entity($data);
        $expected = array('id' => 1, 'name' => 'cspray', 'apiUrl' => 'https://api.github.com/', 'anObject' => new \stdClass());
        $didLoop = false;
        foreach($Entity as $property => $value) {
            if (!$didLoop) {
                $didLoop = true;
            }
            $this->assertArrayHasKey($property, $expected);
            $this->assertEquals($value, $expected[$property]);
        }
        $this->assertTrue($didLoop, 'We did not run through any loop although we expected to.');
    }

    /**
     * @brief Assures that restricted properties cannot be accessed.
     */
    public function testAccessingRestrictedProperty() {
        $data = array(
            'id' => 1,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/',
            'anObject' => null
        );
        $Entity = new \DataFoundry\Test\Helpers\Entity($data);
        $this->assertSame(1, $Entity->id);
        $this->assertNull($Entity->accessibleProperties);
        $this->assertNull($Entity->restrictedProperty);
    }

    /**
     * @brief Ensures that a restricted property may still have its value set at
     * construction.
     */
    public function testAssigningValueToRestrictedProperty() {
        $data = array(
            'id' => 1,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/',
            'anObject' => null,
            'somethingSetByData' => 'Dyana'
        );
        $Entity = new \DataFoundry\Test\Helpers\Entity($data);
        $this->assertSame(null, $Entity->somethingSetByData);
        $this->assertSame('Dyana', $Entity->getSomethingSet());
    }

    /**
     * @brief Ensures that a cloned entity does not reference the same object but
     * the same information is available.
     */
    public function testCloningAnEntity() {
        $data = array(
            'id' => 1,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/',
            'anObject' => null
        );
        $Entity = new \DataFoundry\Test\Helpers\Entity($data);
        $Clone = clone $Entity;
        $this->assertNotSame($Clone, $Entity);
        $this->assertSame($Entity->id, $Clone->id);
        $this->assertSame($Entity->name, $Clone->name);
        $this->assertSame($Entity->apiUrl, $Clone->apiUrl);
        $this->assertEquals($Entity->anObject, $Clone->anObject);
        $this->assertNull($Clone->dataFoundryAllProperties);
        $this->assertNull($Clone->dataFoundryAccessibleProperties);
        $this->assertNull($Clone->somethingSetByData);
    }
}
