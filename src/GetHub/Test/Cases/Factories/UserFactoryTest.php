<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of UserFactoryTest
 */

namespace GetHub\Test\Cases\Factories;

class UserFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @property $Factory GetHub.Factories.UserFactory
     */
    protected $Factory;

    /**
     * @brief Ensures that we have a UserFactory to use for making objects
     */
    public function setUp() {
        if (!isset($this->Factory)) {
            $UserStubFactory = new \GetHub\Factories\UserStubFactory();
            $this->Factory = new \GetHub\Factories\UserFactory($UserStubFactory);
        }
    }

    /**
     * @brief Ensures that the factory is creating a valid user properly.
     */
    public function testCreatingValidUser() {
        $data = array(
            'id' => 1,
            'login' => 'cspray',
            'name' => 'Charles Sprayberry',
            'gravatar_id' => '#cspray',
            'url' => 'https://api.github.com/users/cspray',
            'blog' => 'http://cspray.github.com',
            'created_at' => '1984-02-03T15:33:00Z',
            'public_repos' => 2,
            'public_gists' => 5,
            'followers' => array(
                array(
                    'id' => 2,
                    'name' => 'octocat',
                    'apiUrl' => 'https://api.github.com/users/octocat',
                    'gravatarId' => '#octocat'
                ),
                array(
                    'id' => 3,
                    'name' => 'ircmaxell',
                    'apiUrl' => 'https://api.github.com/users/ircmaxll',
                    'gravatarId' => '#ircmaxell'
                ),
                array(
                    'id' => 4,
                    'name' => 'nikic',
                    'apiUrl' => 'https://api.github.com/users/nikic',
                    'gravatarId' => '#nikic'
                )
            ),
            'following' => array(
                'following'
            ),
            'hireable' => true,
            'bio' => 'Hi, my name is Charles.',
            'location' => 'Gitopolis',
            'email' => 'cspray@gmail.com'
        );

        $User = $this->Factory->createObject($data);
        $this->assertTrue($User instanceof \GetHub\Entities\User);
        $this->assertSame(1, $User->id);
        $this->assertSame('cspray', $User->name);
        $this->assertSame('Charles Sprayberry', $User->fullName);
        $this->assertSame('#cspray', $User->gravatarId);
        $this->assertSame('https://api.github.com/users/cspray', $User->apiUrl);
        $this->assertSame('http://cspray.github.com', $User->blogUrl);
        $this->assertSame('1984-02-03T15:33:00Z', $User->createdAt);
        $this->assertSame(2, $User->publicRepoStubs);
        $this->assertSame(5, $User->publicGistStubs);
        $this->assertTrue($User->isHireable);
        $this->assertSame('Hi, my name is Charles.', $User->bio);
        $this->assertSame('Gitopolis', $User->location);
        $this->assertSame('cspray@gmail.com', $User->email);
        $followers = $User->followers;
        foreach ($followers as $follower) {
            $this->assertTrue($follower instanceof \GetHub\Entities\UserStub, 'A follower is not a UserStub:');
        }
    }

}
