<?php

/**
 * @file
 * @brief Holds a class testing the GetHub.Entities.UserStub object and the creation
 * of a NullObject
 */

namespace GetHub\Test\Cases\Entities;

class UserStubTest extends \PHPUnit_Framework_TestCase {

    /**
     * @brief Testing a basic, valid GetHub.Entities.UserStub object
     */
    public function testBasicGetHubUserStub() {
        $data = array(
            'id' => 3,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/users/cspray',
            'gravatarId' => '#cspray',
        );
        $Stub = new \GetHub\Entities\UserStub($data);
        $this->assertSame(3, $Stub->id);
        $this->assertSame('cspray', $Stub->name);
        $this->assertSame('https://api.github.com/users/cspray', $Stub->apiUrl);
        $this->assertSame('http://www.gravatar.com/avatar/#cspray', $Stub->getGravatarUrl());
        $this->assertSame('http://github.com/cspray', $Stub->getProfileUrl());
    }

    /**
     * @brief Testing to make sure that an appropriate NullObject is created
     */
    public function testNullUserStub() {
        $Stub = new \GetHub\Entities\UserStub(array());
        $this->assertSame(0, $Stub->id);
        $this->assertSame('http://www.gravatar.com/avatar/', $Stub->getGravatarUrl());
        $this->assertSame('', $Stub->name);
        $this->assertSame('https://api.github.com/', $Stub->apiUrl);
        $this->assertSame('http://github.com/', $Stub->getProfileUrl());
    }

    /**
     * @brief Testing that if additional, non-set properties are added in the data
     * array the property is not set to the value.
     */
    public function testAddingInvalidArguments() {
        $data = array(
            'id' => 4,
            'name' => 'cspray',
            'apiUrl' => 'https://api.github.com/users/cspray',
            'gravatarId' => '#',
            'doesNotBelong' => 'nothing here',
            'thisToo' => 'should have nothing in it'
        );
        $Stub = new \GetHub\Entities\UserStub($data);
        $this->assertSame(4, $Stub->id);
        $this->assertSame('cspray', $Stub->name);
        $this->assertSame('https://api.github.com/users/cspray', $Stub->apiUrl);
        $this->assertSame('#', $Stub->gravatarId);
        $this->assertNull($Stub->doesNotBelong);
        $this->assertFalse(isset($Stub->thisToo));
    }

}
