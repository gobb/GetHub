<?php

/**
 * @file
 * @brief Hodls a file that tests the basic functionality of a GetHub.Entity object
 */

namespace GetHub\Test\Cases;

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
        $Entity = new \GetHub\Test\Helpers\Entity($data);
        $this->assertSame(1, $Entity->id);
        $this->assertSame('cspray', $Entity->name);
        $this->assertSame('https://api.github.com/', $Entity->apiUrl);
        $this->assertSame('stdClass',  \get_class($Entity->anObject));
        $this->assertTrue($Entity->anObject instanceof \stdClass);
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
        $Entity = new \GetHub\Test\Helpers\Entity($data);
        $this->assertTrue(isset($Entity->id));
        $this->assertTrue(isset($Entity->name));
        $this->assertTrue(isset($Entity->apiUrl));
        $this->assertTrue(isset($Entity->anObject));
        $this->assertFalse(isset($Entity->objectVars));
        $this->assertFalse(isset($Entity->doNotExist));
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
        $Entity = new \GetHub\Test\Helpers\Entity($data);
        $exceptionThrown = false;
        try {
            unset($Entity->id);
        } catch (\DomainException $DomainException) {
            $exceptionThrown = true;
            $this->assertSame('The property, id, may not be unset.', $DomainException->getMessage());
        }
        $this->assertTrue($exceptionThrown);
    }



}