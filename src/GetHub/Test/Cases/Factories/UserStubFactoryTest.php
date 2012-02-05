<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of GetHub.Entities.UserStub
 */

namespace GetHub\Test\Cases\Factories;

class UserStubFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @property $Factory GetHub.Factories.UserStubFactory
     */
    protected $Factory;

    /**
     * @brief Ensures that we have a UserStubFactory to create GetHub.Entities.UserStub
     * objects with.
     */
    public function setUp() {
        if (!isset($this->Factory)) {
            $this->Factory = new \GetHub\Factories\UserStubFactory();
        }
    }

    /**
     * @brief Tests that the factory is producing a valid object correctly
     */
    public function testUserStubFactoryCreatingValidEntity() {
        $data = array(
            'id' => 1,
            'login' => 'cspray',
            'gravatar_id' => '#1234',
            'url' => 'https://api.github.com/users/cspray'
        );
        $Stub = $this->Factory->createObject($data);
        $this->assertTrue($Stub instanceof \GetHub\Entities\UserStub);
        $this->assertSame(1, $Stub->id);
        $this->assertSame('cspray', $Stub->name);
        $this->assertSame('#1234', $Stub->gravatarId);
        $this->assertSame('https://api.github.com/users/cspray', $Stub->apiUrl);
    }

    /**
     * @brief Ensuring that the appropriate object is returned if no data is passed
     */
    public function testUserStubFactoryCreatingNullObject() {
        $Stub = $this->Factory->createObject();
        $gravatarHash = \md5();
        $this->assertTrue($Stub instanceof \GetHub\Entities\UserStub);
        $this->assertSame(0, $Stub->id);
        $this->assertSame('', $Stub->name);
        $this->assertSame('', $Stub->gravatarId);
        $this->assertSame('https://api.github.com', $Stub->apiUrl);
    }

}
