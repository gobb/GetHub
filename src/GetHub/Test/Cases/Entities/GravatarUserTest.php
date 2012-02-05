<?php

/**
 * @file
 * @brief Holds a class testing the functionality we expect to get from our
 * GravatarUser object
 */

namespace GetHub\Test\Cases\Entities;

class GravatarUserTest extends \PHPUnit_Framework_TestCase {

    /**
     * @brief Testing that we can get back the basic gravatar URL with no extensions.
     */
    public function testGettingUrlWithNoExtension() {
        $data = array(
            'gravatarId' => '#'
        );
        $GravatarUser = new \GetHub\Entities\GravatarUser($data);
        $this->assertSame('http://www.gravatar.com/avatar/#', $GravatarUser->getGravatarUrl());
    }

}