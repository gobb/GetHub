<?php

/**
 * @file
 * @brief A data object representing repository information returned from a request
 * for a list of user's or organization repositories.
 */

namespace GetHub\Entities;

class RepoStub extends \DataFoundry\Entity {

    /**
     * @return array Numeric index array of properties to not allow access to
     */
    protected function getRestrictedProperties() {
        return array();
    }


}
