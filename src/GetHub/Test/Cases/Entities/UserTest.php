<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of UserTest
 */

namespace GetHub\Test\Cases;

class UserTest extends \PHPUnit_Framework_TestCase {

    /**
     * @brief Tests that a basic, valid GetHub.Entities.User object is created
     * properly.
     */
    public function testCreatingBasicUserObject() {
        $data = array(
            'id' => 1,
            'name' => 'cspray',
            'fullName' => 'Charles Sprayberry',
            'gravatarId' => '#cspray',
            'apiUrl' => 'https://api.github.com/users/cspray',
            'blogUrl' => 'http://cspray.github.com',
            'createdAt' => '1984-02-03T15:33:00Z',
            'publicRepoStubs' => array(
                '\\GetHub\\Entities\\RepoStubs'
            ),
            'publicGistStubs' => array(
                '\\GetHub\\Entities\\GistStubs'
            ),
            'followers' => array(
                'followers'
            ),
            'following' => array(
                'following'
            ),
            'isHireable' => true,
            'bio' => 'Hi, my name is Charles.',
            'location' => 'Gitopolis',
            'email' => 'cspray@gmail.com'
        );
        $User = new \GetHub\Entities\User($data);
        $this->assertSame(1, $User->id);
        $this->assertSame('cspray', $User->name);
        $this->assertSame('Charles Sprayberry', $User->fullName);
        $this->assertSame('#cspray', $User->gravatarId);
        $this->assertSame('https://api.github.com/users/cspray', $User->apiUrl);
        $this->assertSame('http://cspray.github.com', $User->blogUrl);
        $this->assertSame('1984-02-03T15:33:00Z', $User->createdAt);
        $this->assertSame(array('\\GetHub\\Entities\\RepoStubs'), $User->publicRepoStubs);
        $this->assertSame(array('\\GetHub\\Entities\\GistStubs'), $User->publicGistStubs);
        $this->assertSame(array('followers'), $User->followers);
        $this->assertSame(array('following'), $User->following);
        $this->assertTrue($User->isHireable);
        $this->assertSame('Hi, my name is Charles.', $User->bio);
        $this->assertSame('Gitopolis', $User->location);
        $this->assertSame('cspray@gmail.com', $User->email);
    }

    /**
     * @brief Ensures that a NullObject is returning the appropriate values
     */
    public function testCreatingNullUserObject() {
        $User = new \GetHub\Entities\User(array());
        $this->assertSame(0, $User->id, 'id failed:');
        $this->assertSame('', $User->name, 'name failed:');
        $this->assertSame('', $User->fullName, 'fullName failed:');
        $this->assertSame('', $User->gravatarId, 'gravatarId failed:');
        $this->assertSame('https://api.github.com/', $User->apiUrl, 'apiUrl failed:');
        $this->assertSame('http://github.com/blog', $User->blogUrl, 'blogUrl failed:');
        $this->assertSame('0000-00-00T00:00:00Z', $User->createdAt, 'createdAt failed:');
        $this->assertSame(array(), $User->publicRepoStubs, 'publicRepoStubs failed:');
        $this->assertSame(array(), $User->publicGistStubs, 'publicGistStubs failed:');
        $this->assertSame(array(), $User->followers, 'followers failed:');
        $this->assertSame(array(), $User->following, 'following failed:');
        $this->assertFalse($User->isHireable, 'isHireable failed:');
        $this->assertSame('', $User->bio, 'bio failed:');
        $this->assertSame('', $User->location, 'location failed:');
        $this->assertSame('', $User->email, 'email failed:');
    }
}
