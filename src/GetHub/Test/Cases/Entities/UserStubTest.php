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
        $gravatarId = \md5('rolltiderollsprayfireisthebombo@thisisnotsupposedtomakesense.com');
        $Stub = new \GetHub\Entities\UserStub(array());
        $this->assertSame(0, $Stub->id);
        $this->assertSame('http://www.gravatar.com/avatar/' . $gravatarId, $Stub->getGravatarUrl());
        $this->assertSame('', $Stub->name);
        $this->assertSame('https://api.github.com/', $Stub->apiUrl);
        $this->assertSame('http://github.com/', $Stub->getProfileUrl());
    }

}