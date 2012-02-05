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

    public function testIssetOnEntityProperties() {
        
    }



}