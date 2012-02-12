<?php

/**
 * @file
 * @brief A helper object to test that entity objects properly set their member
 * data.
 */

namespace DataFoundry\Test\Helpers;

class Entity extends \DataFoundry\Entity {

    protected $id = 0;

    protected $name = 'gethubocat';

    protected $apiUrl = 'https://cspray.github.com/api/';

    protected $anObject = null;

    protected $restrictedProperty = 'Accessing this property should return null';

    protected $somethingSetByData = '';

    public function __construct(array $data) {
        $this->anObject = new \stdClass();
        parent::__construct($data);
    }

    public function getRestrictedProperties() {
        return array('restrictedProperty', 'somethingSetByData');
    }

    public function getSomethingSet() {
        return $this->somethingSetByData;
    }

}