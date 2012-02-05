<?php

/**
 * @file
 * @brief Holds a class responsible for providing gravatar functionality to GetHub
 */

namespace GetHub\Entities;

class GravatarUser extends \GetHub\Entity {

    /**
     * @brief The hash for the user's gravatar
     *
     * @property $gravatarId string
     */
    protected $gravatarId;

    /**
     * @brief The URL to use for retrieving Gravatar images.
     *
     * @details
     * This value is restricted and is not allowed to be returned.
     *
     * @property $gravatarUrl string
     */
    protected $gravatarUrl = 'http://www.gravatar.com/avatar/';

    public function __construct(array $data) {
        $hash = \md5('rolltiderollsprayfireisthebombo@thisisnotsupposedtomakesense.com');
        $this->gravatarId = $hash;
        parent::__construct($data);
        unset($this->objectVars['gravatarUrl']);
    }

    /**
     * @param $imgExtension boolean Whether or not to include a .jpg extension on image
     * @return string The URL to retrieve a user's gravatar
     */
    public function getGravatarUrl($imgExtension = false) {
        $url = $this->gravatarUrl . $this->gravatarId;
        if ((bool) $imgExtension) {
            $url .= '.jpg';
        }
        return $url;
    }

}