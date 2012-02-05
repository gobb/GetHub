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
        $this->assertFalse(isset($Entity->gravatarUrl));
    }

    /**
     * @brief Testing that we get back the proper extension if the flag is passed
     */
    public function testGettingUrlWithExtension() {
        $data = array(
            'gravatarId' => '#'
        );
        $GravatarUser = new \GetHub\Entities\GravatarUser($data);
        $this->assertSame('http://www.gravatar.com/avatar/#.jpg', $GravatarUser->getGravatarUrl(true));
    }

    /**
     * @brief Testing that we get back a proper NullObject is no data is passed in
     */
    public function testGettingNullObject() {
        $GravatarUser = new \GetHub\Entities\GravatarUser(array());
        $this->assertSame('http://www.gravatar.com/avatar/', $GravatarUser->getGravatarUrl());
    }

}