<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of UserFactoryTest
 *
 * @details
 * Please note that we are testing the convenience functions for the GetHub.Entities.User
 * object in this test case because the object by itself does not have the capability
 * to create stubs to replace various array data.  Since these functions will rely
 * on the fact that stubs are expected in certain places they can only be checked
 * by creating one via the factory.
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
                    'login' => 'edorian',
                    'url' => 'https://api.github.com/users/edorian',
                    'gravatar_id' => '#edorian'
                ),
                array(
                    'id' => 3,
                    'login' => 'ircmaxell',
                    'url' => 'https://api.github.com/users/ircmaxell',
                    'gravatar_id' => '#ircmaxell'
                ),
                array(
                    'id' => 4,
                    'login' => 'nikic',
                    'url' => 'https://api.github.com/users/nikic',
                    'gravatar_id' => '#nikic'
                )
            ),
            'following' => array(
                array(
                    'id' => 5,
                    'login' => 'teresko',
                    'url' => 'https://api.github.com/users/teresko',
                    'gravatar_id' => '#teresko'
                ),
                array(
                    'id' => 6,
                    'login' => 'PeeHaa',
                    'url' => 'https://api.github.com/users/PeeHaa',
                    'gravatar_id' => '#PeeHaa'
                )
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
        $expectedFollowerData = array(
            array(
                'id' => 2,
                'login' => 'edorian',
                'url' => 'https://api.github.com/users/edorian',
                'gravatar_id' => '#edorian'
            ),
            array(
                'id' => 3,
                'login' => 'ircmaxell',
                'url' => 'https://api.github.com/users/ircmaxell',
                'gravatar_id' => '#ircmaxell'
            ),
            array(
                'id' => 4,
                'login' => 'nikic',
                'url' => 'https://api.github.com/users/nikic',
                'gravatar_id' => '#nikic'
            )
        );

        $expectedFollowerIndex = 0;
        foreach ($followers as $follower) {
            $this->assertTrue($follower instanceof \GetHub\Entities\UserStub, 'A follower is not a UserStub:');
            $followerData = $expectedFollowerData[$expectedFollowerIndex];
            $this->assertSame($followerData['id'], $follower->id);
            $this->assertSame($followerData['login'], $follower->name);
            $this->assertSame($followerData['url'], $follower->apiUrl);
            $this->assertSame($followerData['gravatar_id'], $follower->gravatarId);
            $expectedFollowerIndex++;
        }

        $following = $User->following;
        $expectedFollowingData = array(
            array(
                'id' => 5,
                'login' => 'teresko',
                'url' => 'https://api.github.com/users/teresko',
                'gravatar_id' => '#teresko'
            ),
            array(
                'id' => 6,
                'login' => 'PeeHaa',
                'url' => 'https://api.github.com/users/PeeHaa',
                'gravatar_id' => '#PeeHaa'
            )
        );

        $expectedFollowingIndex = 0;
        foreach ($following as $userFollowing) {
            $this->assertTrue($userFollowing instanceof \GetHub\Entities\UserStub, 'A following user is not a UserStub');
            $followingData = $expectedFollowingData[$expectedFollowingIndex];
            $this->assertSame($followingData['id'], $userFollowing->id);
            $this->assertSame($followingData['login'], $userFollowing->name);
            $this->assertSame($followingData['url'], $userFollowing->apiUrl);
            $this->assertSame($followingData['gravatar_id'], $userFollowing->gravatarId);
            $expectedFollowingIndex++;
        }
    }

    /**
     * @brief Testing the convenience function to see if a user has a follower for
     * a given name.
     */
    public function testConvenienceFunctionHasFollowerByName() {
        $data = array(
            'followers' => array(
                array(
                    'id' => 2,
                    'login' => 'edorian',
                    'url' => 'https://api.github.com/users/edorian',
                    'gravatar_id' => '#edorian'
                ),
                array(
                    'id' => 3,
                    'login' => 'ircmaxell',
                    'url' => 'https://api.github.com/users/ircmaxell',
                    'gravatar_id' => '#ircmaxell'
                ),
                array(
                    'id' => 4,
                    'login' => 'nikic',
                    'url' => 'https://api.github.com/users/nikic',
                    'gravatar_id' => '#nikic'
                )
            )
        );
        $User = $this->Factory->createObject($data);
        $this->assertTrue($User->hasFollowerByName('edorian'));
        $this->assertTrue($User->hasFollowerByName('ircmaxell'));
        $this->assertFalse($User->hasFollowerByName('notthere'));
    }

    /**
     * @brief Testing the convenience function to see if a user has a follower that
     * has a given id.
     *
     */
    public function testConvenienceFunctionHasFollowerById() {
        $data = array(
            'followers' => array(
                array(
                    'id' => 2,
                    'login' => 'edorian',
                    'url' => 'https://api.github.com/users/edorian',
                    'gravatar_id' => '#edorian'
                ),
                array(
                    'id' => 3,
                    'login' => 'ircmaxell',
                    'url' => 'https://api.github.com/users/ircmaxell',
                    'gravatar_id' => '#ircmaxell'
                ),
                array(
                    'id' => 4,
                    'login' => 'nikic',
                    'url' => 'https://api.github.com/users/nikic',
                    'gravatar_id' => '#nikic'
                )
            )
        );
        $User = $this->Factory->createObject($data);
        $this->assertTrue($User->hasFollowerById(2));
        $this->assertTrue($User->hasFollowerById('4'));
        $this->assertFalse($User->hasFollowerByName(5));
    }

}
