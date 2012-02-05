<?php

/**
 * @file
 * @brief A helper object to test that entity objects properly set their member
 * data.
 */

namespace GetHub\Test\Helpers;

class Entity extends \GetHub\Entity {

    protected $id = 0;

    protected $name = 'gethubocat';

    protected $apiUrl = 'https://cspray.github.com/api/';

    protected $anObject = null;

    public function __construct(array $data) {
        $this->anObject = new \stdClass();
        parent::__construct($data);
    }

}