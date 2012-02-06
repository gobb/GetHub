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
        $this->assertSame(false, $User->isHireable);
        $this->assertSame('Hi, my name is Charles.', $User->bio);
        $this->assertSame('Gitopolis', $User->location);
        $this->assertSame('cspray@gmail.com', $User->email);

    }
}
