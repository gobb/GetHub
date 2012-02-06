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

    /**
     * @brief Tests that we can always return a GetHub.Entities.UserStub object
     * when we call getFollowerById().
     */
    public function testConvenienceFunctionGetFollowerById() {
        $edorianData = array(
            'id' => 2,
            'name' => 'edorian',
            'apiUrl' => 'https://api.github.com/users/edorian',
            'gravatarId' => '#edorian'
        );
        $ircmaxellData = array(
            'id' => 3,
            'name' => 'ircmaxell',
            'apiUrl' => 'https://api.github.com/users/ircmaxell',
            'gravatarId' => '#ircmaxell'
        );
        $nikicData = array(
            'id' => 4,
            'name' => 'nikic',
            'apiUrl' => 'https://api.github.com/users/nikic',
            'gravatarId' => '#nikic'
        );

        $data['followers'] = array();
        $data['followers'][] = new \GetHub\Entities\UserStub($edorianData);
        $data['followers'][] = new \GetHub\Entities\UserStub($ircmaxellData);
        $data['followers'][] = new \GetHub\Entities\UserStub($nikicData);

        $User = new \GetHub\Entities\User($data);

        $three = $User->getFollowerStubById(3);
        $this->assertTrue($three instanceof \GetHub\Entities\UserStub, 'getting 3:ircmaxell stub returned non stub object:');
        $this->assertSame(3, $three->id);
        $this->assertSame('ircmaxell', $three->name);
        $this->assertSame('https://api.github.com/users/ircmaxell', $three->apiUrl);
        $this->assertSame('#ircmaxell', $three->gravatarId);

        $noexist = $User->getFollowerStubById('0');
        $this->assertTrue($noexist instanceof \GetHub\Entities\UserStub, 'getting noexist stub returned non stub object:');
        $this->assertSame(0, $noexist->id);
    }

    /**
     * @brief Tests that we can always return a GetHub.Entities.UserStub object
     * when we call getFollowerByName().
     */
    public function testConvenienceFunctionGetFollowerByName() {
        $edorianData = array(
            'id' => 2,
            'name' => 'edorian',
            'apiUrl' => 'https://api.github.com/users/edorian',
            'gravatarId' => '#edorian'
        );
        $ircmaxellData = array(
            'id' => 3,
            'name' => 'ircmaxell',
            'apiUrl' => 'https://api.github.com/users/ircmaxell',
            'gravatarId' => '#ircmaxell'
        );
        $nikicData = array(
            'id' => 4,
            'name' => 'nikic',
            'apiUrl' => 'https://api.github.com/users/nikic',
            'gravatarId' => '#nikic'
        );

        $data['followers'] = array();
        $data['followers'][] = new \GetHub\Entities\UserStub($edorianData);
        $data['followers'][] = new \GetHub\Entities\UserStub($ircmaxellData);
        $data['followers'][] = new \GetHub\Entities\UserStub($nikicData);

        $User = new \GetHub\Entities\User($data);

        $edorian = $User->getFollowerStubByName('edorian');
        $this->assertTrue($edorian instanceof \GetHub\Entities\UserStub, 'getting edorian stub returned non stub object:');
        $this->assertSame(2, $edorian->id);
        $this->assertSame('edorian', $edorian->name);
        $this->assertSame('https://api.github.com/users/edorian', $edorian->apiUrl);
        $this->assertSame('#edorian', $edorian->gravatarId);

        $noexist = $User->getFollowerStubByName('noexist');
        $this->assertTrue($noexist instanceof \GetHub\Entities\UserStub, 'getting noexist stub returned non stub object:');
        $this->assertSame(0, $noexist->id);
    }

    /**
     * @brief Testing the convenience function to see if a user has a follower for
     * a given name.
     */
    public function testConvenienceFunctionHasFollowerByName() {
        $edorianData = array(
            'id' => 2,
            'name' => 'edorian',
            'apiUrl' => 'https://api.github.com/users/edorian',
            'gravatarId' => '#edorian'
        );
        $ircmaxellData = array(
            'id' => 3,
            'name' => 'ircmaxell',
            'apiUrl' => 'https://api.github.com/users/ircmaxell',
            'gravatarId' => '#ircmaxell'
        );
        $nikicData = array(
            'id' => 4,
            'name' => 'nikic',
            'apiUrl' => 'https://api.github.com/users/nikic',
            'gravatarId' => '#nikic'
        );

        $data['followers'] = array();
        $data['followers'][] = new \GetHub\Entities\UserStub($edorianData);
        $data['followers'][] = new \GetHub\Entities\UserStub($ircmaxellData);
        $data['followers'][] = new \GetHub\Entities\UserStub($nikicData);

        $User = new \GetHub\Entities\User($data);
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
        $edorianData = array(
            'id' => 2,
            'name' => 'edorian',
            'apiUrl' => 'https://api.github.com/users/edorian',
            'gravatarId' => '#edorian'
        );
        $ircmaxellData = array(
            'id' => 3,
            'name' => 'ircmaxell',
            'apiUrl' => 'https://api.github.com/users/ircmaxell',
            'gravatarId' => '#ircmaxell'
        );
        $nikicData = array(
            'id' => 4,
            'name' => 'nikic',
            'apiUrl' => 'https://api.github.com/users/nikic',
            'gravatarId' => '#nikic'
        );

        $data['followers'] = array();
        $data['followers'][] = new \GetHub\Entities\UserStub($edorianData);
        $data['followers'][] = new \GetHub\Entities\UserStub($ircmaxellData);
        $data['followers'][] = new \GetHub\Entities\UserStub($nikicData);

        $User = new \GetHub\Entities\User($data);
        $this->assertTrue($User->hasFollowerById(2), 'Does not have follower 2');
        $this->assertTrue($User->hasFollowerById('4'), 'Does not have follower 4');
        $this->assertFalse($User->hasFollowerById(5), 'Does not have follower 5');
    }

    /**
     * @brief Testing the convenience function to see if this user is following a
     * user with a given id
     */
    public function testConvenienceFunctionIsFollowingById() {
        $edorianData = array(
            'id' => 2,
            'name' => 'edorian',
            'apiUrl' => 'https://api.github.com/users/edorian',
            'gravatarId' => '#edorian'
        );
        $ircmaxellData = array(
            'id' => 3,
            'name' => 'ircmaxell',
            'apiUrl' => 'https://api.github.com/users/ircmaxell',
            'gravatarId' => '#ircmaxell'
        );
        $nikicData = array(
            'id' => 4,
            'name' => 'nikic',
            'apiUrl' => 'https://api.github.com/users/nikic',
            'gravatarId' => '#nikic'
        );

        $data['following'] = array();
        $data['following'][] = new \GetHub\Entities\UserStub($edorianData);
        $data['following'][] = new \GetHub\Entities\UserStub($ircmaxellData);
        $data['following'][] = new \GetHub\Entities\UserStub($nikicData);

        $User = new \GetHub\Entities\User($data);
        $this->assertTrue($User->isFollowingById(2), 'Does not have follower 2');
        $this->assertTrue($User->isFollowingById('4'), 'Does not have follower 4');
        $this->assertFalse($User->isFollowingById(5), 'Does not have follower 5');
    }

    /**
     * @brief Testing the convenience function to see if this user is following a
     * user with a given name
     */
    public function testConvenienceFunctionIsFollowingByName() {
        $edorianData = array(
            'id' => 2,
            'name' => 'edorian',
            'apiUrl' => 'https://api.github.com/users/edorian',
            'gravatarId' => '#edorian'
        );
        $ircmaxellData = array(
            'id' => 3,
            'name' => 'ircmaxell',
            'apiUrl' => 'https://api.github.com/users/ircmaxell',
            'gravatarId' => '#ircmaxell'
        );
        $nikicData = array(
            'id' => 4,
            'name' => 'nikic',
            'apiUrl' => 'https://api.github.com/users/nikic',
            'gravatarId' => '#nikic'
        );

        $data['following'] = array();
        $data['following'][] = new \GetHub\Entities\UserStub($edorianData);
        $data['following'][] = new \GetHub\Entities\UserStub($ircmaxellData);
        $data['following'][] = new \GetHub\Entities\UserStub($nikicData);

        $User = new \GetHub\Entities\User($data);
        $this->assertTrue($User->isFollowingByName('nikic'), 'Is not following nikic: ');
        $this->assertTrue($User->isFollowingByName('edorian'), 'Is not following edorian: ');
        $this->assertFalse($User->isFollowingByName('nothere'), 'Is not following nothere: ');
    }

    /**
     * @brief Will ensure that a GetHub.Entities.UserStub is always returned from
     * GetHub.Entities.User::getFollowingStubByName()
     */
    public function testConvenienceFunctionGetFollowingByName() {
        $edorianData = array(
            'id' => 2,
            'name' => 'edorian',
            'apiUrl' => 'https://api.github.com/users/edorian',
            'gravatarId' => '#edorian'
        );
        $ircmaxellData = array(
            'id' => 3,
            'name' => 'ircmaxell',
            'apiUrl' => 'https://api.github.com/users/ircmaxell',
            'gravatarId' => '#ircmaxell'
        );
        $nikicData = array(
            'id' => 4,
            'name' => 'nikic',
            'apiUrl' => 'https://api.github.com/users/nikic',
            'gravatarId' => '#nikic'
        );

        $data['following'] = array();
        $data['following'][] = new \GetHub\Entities\UserStub($edorianData);
        $data['following'][] = new \GetHub\Entities\UserStub($ircmaxellData);
        $data['following'][] = new \GetHub\Entities\UserStub($nikicData);

        $User = new \GetHub\Entities\User($data);

        $edorian = $User->getFollowingStubByName('edorian');
        $this->assertTrue($edorian instanceof \GetHub\Entities\UserStub, 'getting edorian stub returned non stub object:');
        $this->assertFalse($edorian instanceof \GetHub\Entities\User, 'getting a User object when expecting a UserStub');
        $this->assertSame(2, $edorian->id);
        $this->assertSame('edorian', $edorian->name);
        $this->assertSame('https://api.github.com/users/edorian', $edorian->apiUrl);
        $this->assertSame('#edorian', $edorian->gravatarId);

        $noexist = $User->getFollowingStubByName('noexist');
        $this->assertTrue($noexist instanceof \GetHub\Entities\UserStub, 'getting noexist stub returned non stub object:');
        $this->assertSame(0, $noexist->id);
    }

    /**
     * @brief Will ensure that a GetHub.Entities.UserStub is always returned from
     * GetHub.Entities.User::getFollowingStubById()
     */
    public function testConvenienceFunctionGetFollowingById() {
        $edorianData = array(
            'id' => 2,
            'name' => 'edorian',
            'apiUrl' => 'https://api.github.com/users/edorian',
            'gravatarId' => '#edorian'
        );
        $ircmaxellData = array(
            'id' => 3,
            'name' => 'ircmaxell',
            'apiUrl' => 'https://api.github.com/users/ircmaxell',
            'gravatarId' => '#ircmaxell'
        );
        $nikicData = array(
            'id' => 4,
            'name' => 'nikic',
            'apiUrl' => 'https://api.github.com/users/nikic',
            'gravatarId' => '#nikic'
        );

        $data['following'] = array();
        $data['following'][] = new \GetHub\Entities\UserStub($edorianData);
        $data['following'][] = new \GetHub\Entities\UserStub($ircmaxellData);
        $data['following'][] = new \GetHub\Entities\UserStub($nikicData);

        $User = new \GetHub\Entities\User($data);

        $four = $User->getFollowingStubById('4');
        $this->assertTrue($four instanceof \GetHub\Entities\UserStub, 'getting edorian stub returned non stub object:');
        $this->assertFalse($four instanceof \GetHub\Entities\User, 'Getting a User object back when expecting a stub');
        $this->assertSame(4, $four->id);
        $this->assertSame('nikic', $four->name);
        $this->assertSame('https://api.github.com/users/nikic', $four->apiUrl);
        $this->assertSame('#nikic', $four->gravatarId);

        $noexist = $User->getFollowingStubById(5);
        $this->assertTrue($noexist instanceof \GetHub\Entities\UserStub, 'getting noexist stub returned non stub object:');
        $this->assertSame(0, $noexist->id);
    }

}
