<?php

/**
 * @file
 * @brief Holds a PHPUnit test case to confirm the functionality of RepoStubTest
 */

namespace GetHub\Test\Cases\Entities;

class RepoStubTest extends \PHPUnit_Framework_TestCase {

    /**
     * @brief Ensures that the basic RepoStub can be created appropriately.
     */
    public function testCreatingBasicRepoStub() {
        $repoOwnerData = array(
            'id' => 1,
            'name' => 'cspray',
            'gravatarId' => '#cspray',
            'apiUrl' => 'https://api.github.com/users/cspray'
        );
        $RepoOwner = new \GetHub\Entities\UserStub($repoOwnerData);

        $data = array(
            'apiUrl' => 'https://api.github.com/repos/cspray/GetHub',
            'websiteUrl' => 'https://github.com/cspray/GetHub',
            'gitCloneUrl' => 'git://github.com/cspray/GetHub.git',
            'owner' => $RepoOwner,
            'name' => 'GetHub',
            'description' => 'This is the description of the awesomeness that is GetHub.',
            'homepage' => null,
            'language' => 'PHP',
            'isPrivate' => false,
            'isFork' => false,
            'numberOfTimesForked' => 10,
            'numberOfWatchers' => 5,
            'masterBranch' => 'master',
            'openIssues' => 10,
            'pushedAt' => '2012-01-01T14:35:20',
            'createdAt' => '2011-12-31T01:49:00'
        );
        $RepoStub = new \GetHub\Entities\RepoStub($data);
        $this->assertSame('https://api.github.com/repos/cspray/GetHub', $RepoStub->apiUrl);
        $this->assertSame('https://github.com/cspray/GetHub', $RepoStub->websiteUrl);
        $this->assertSame('git://github.com/cspray/GetHub.git', $RepoStub->gitCloneUrl);
        $this->assertSame($RepoOwner, $RepoStub->owner);
        $this->assertSame('cspray', $RepoStub->owner->name);
        $this->assertSame(1, $RepoStub->owner->id);
        $this->assertSame('GetHub', $RepoOwner->name);
        $this->assertSame('This is the description of the awesomeness that is GetHub.', $RepoStub->description);
        $this->assertNull($RepoStub->homepage);
        $this->assertSame('PHP', $RepoStub->language);
        $this->assertFalse($RepoStub->isPrivate, 'The repository is private but is not expected to be.');
        $this->assertFalse($RepoStub->isFork, 'The repository is a fork but is not expected to be.');
        $this->assertSame(10, $RepoStub->numberOfTimesForked);
        $this->assertSame(5, $RepoStub->numberOfWatchers);
        $this->assertSame('master', $RepoStub->masterBranch);
        $this->assertSame(10, $RepoStub->openIssues);
        $this->assertSame('2012-01-01T14:35:20', $RepoStub->pushedAt);
        $this->assertSame('2011-12-31T01:49:00', $RepoStub->createdAt);
    }

}
