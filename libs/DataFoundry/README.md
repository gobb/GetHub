# DataFoundry

A PHP 5.3 library to easily create read-only data objects.

This documentation applies to DataFoundry v1.0.0.

DataFoundry is released under the OSI MIT License.  Please read the [LICENSE](https://github.com/cspray/DataFoundry/blob/1.0.0/LICENSE) document
for full licensing details.

## How it works

The first part is the actual data object itself: [`DataFoundry\Entity`](//github.com/cspray/DataFoundry/blob/1.0.0/src/DataFoundry/Entity.php), an abstract
class that holds the read-only data that you'd like to use.  This class provides
some basic functionality for assigning data at construction time, providing the
appropriate data when called for, and denying any kind of changing to the data.
There is 1 method that should be implemented by extending classes: [`getRestrictedProperties()`](//github.com/cspray/DataFoundry/blob/1.0.0/src/DataFoundry/Entity.php#L198).
It should return an array of properties that is not "visible" to calling code; i.e.
the property is used internally by the class and should not be readable from the outside.

Here's an example of an entity based off of a [Follower](//developer.github.com/v3/users/followers/)
from the [github v3 API](//developer.github.com/v3/).

> This entity is used in an actual project!  Check it out, I call it [GetHub](//www.github.com/cspray/GetHub).

```php

namespace GetHub\Entities;

class UserStub extends \DataFoundry\Entity {

    /**
     * @brief The numeric github ID for this user
     *
     * @property $id int
     */
    protected $id = 0;

    /**
     * @brief The login for this user
     *
     * @property $name string
     */
    protected $name = '';

    /**
     * @brief The github API URL for this object
     *
     * @property $apiUrl string
     */
    protected $apiUrl = 'https://api.github.com/';

    /**
     * @brief The ID hash for this user's gravatar
     *
     * @property $gravatarId string
     */
    protected $gravatarId = '#';

    /**
     * @brief The URL for a gravatar; used to create the complete URL for this
     * user's gravatar
     *
     * @property $gravatarUrl string
     */
    protected $gravatarUrl = 'http://www.gravatar.com/avatar/'

    /**
     * @return string A URL for the user's github profile
     */
    public function getProfileUrl() {
        return 'http://github.com/' . $this->name;
    }

    /**
     * @return string The complete URL for this user's gravatar
     */
    public function getGravatarUrl() {
        return $this->gravatarUrl . $this->gravatarId;
    }

    /**
     * @brief We are restricting gravatarUrl because it is a helper property used
     * by the class internally.
     *
     * @return array
     * @see DataFoundry.Entities.UserStub::getGravatarUrl()
     */
    protected function getRestrictedProperties() {
        return array('gravatarUrl');
    }

}
```

As you can see the concept is pretty simple and easy to implement.  The properties
that you want set are simply set, you can set them to reasonable default properties
to ensure values are available even if no data is passed into the object.  The `DataFactory\Entity`
object takes care of ensuring only the properties available to the user are accessed
and throws a [`DomainException`](http://php.net/domainexception) if an attempt is made to write or change a value in
any way.

The next part are the factories.  There are two, [`DataFoundry\BaseFactory`](https://github.com/cspray/DataFoundry/blob/1.0.0/src/DataFoundry/BaseFactory.php)
and [`DataFoundry\MapFactory`](https://github.com/cspray/DataFoundry/blob/1.0.0/src/DataFoundry/MapFactory.php).
The base is pretty much just like it sounds; an abstract class for the most very
basic data object construction.  It has one abstract protected method, [`getObjectName()`](https://github.com/cspray/DataFoundry/blob/1.0.0/src/DataFoundry/BaseFactory.php#L53),
that should return a Java or PHP-style namespaced class that the factory should
create when [`DataFoundry\BaseFactory::createObject()`](https://github.com/cspray/DataFoundry/blob/1.0.0/src/DataFoundry/BaseFactory.php#L16) is called.

Below is an example of a class that would create the above UserStub object.

```php
namespace DataFoundry;

class UserStubFactory extends \DataFoundry\BaseFactory {

    /**
     * @return string
     */
    protected getObjectName() {
        return 'DataFoundry.Entities.UserStub';
    }

}
```

However, there's a problem here.  The data properties returned by the github API
don't exactly match up to our naming convention.  This is where the `DataFoundry\MapFactory`
class comes into play.  It extends the Base factory and adds 1 more abstract protected
method to be implemented by the extending class: [`getPropertyMap()`](https://github.com/cspray/DataFoundry/blob/1.0.0/src/DataFoundry/MapFactory.php#L42).  This new function
should return an associative array with the key being the name of the key held in
the array passed to the entity and the value of that key being the name of the property
in that entity.  Here's an example where we fix the previous UserStubFactory to
match the appropriate API data from github by extending the MapFactory instead
of the BaseFactory.

```php
namespace DataFoundry;

class UserStubFactory extends \DataFoundry\MapFactory {

    /**
     * @return string
     */
    protected getObjectName() {
        return 'DataFoundry.Entities.UserStub';
    }

    /**
     * @return array
     */
    protected getPropertyMap() {
        return array(
            'id' => 'id',
            'login' => 'name',
            'gravatar_id' => 'gravatarId',
            'url' => 'apiUrl'
        );
    }

}
```

As you can see we now have the API response from github mapping to the appropriate
property names of the class.  However, please note that we included *ALL* of the
property mappings, even though `id` is the same for both the API response and the
class property.  If the property map array does not list the key set in the passed
array then that value will not be set.

## Roadmap

**v 1.0.0**

- <del>Abstract class `DataFoundry\Entity` is created and tested, with appropriate values
only being able to be read.</del> Completed: 02/12/2012
- <del>Abstract class `DataFoundry\BaseFactory` is created and tested, creating a `DataFoundry\Entity`
object based on a passed array of data.</del> Completed: 02/12/2012
- <del>Abstract class `DataFoundry\MapFactory` is created and tested, creating a `DataFounrdy\Entity`
object by mapping the keys of a passed data array to the property name associated
with that key.</del> Completed: 02/12/2012

**v 2.0.0**

- Provide `ReadOnly`, `WriteOnly`, and `ReadWrite` entity objects.
- Possibly provide a method to allow one factory to create multiple different entity
objects.

## Geek Data

Below are some numbers for the geeks.

Code Coverage ran on 02/12/2012 12:21:33.

```plain
Total all files

% Lines     # Lines     % Methods   # Methods       % Classes   # Classes
--------------------------------------------------------------------------------
97.01%      65 / 67     94.12%      16 / 17         66.67%      2 / 3



DataFoundry\BaseFactory

% Lines     # Lines     % Methods   # Methods       % Classes   # Classes
--------------------------------------------------------------------------------
90.91%      10 / 11     66.67%      2 / 3           0.00%	0 / 1


DataFoundry\Entity

% Lines     # Lines     % Methods   # Methods       % Classes   # Classes
--------------------------------------------------------------------------------
100.00%     42 / 42     100.00%     12 / 12         100.00%	1 / 1


DataFoundry\MapFactory

% Lines     # Lines     % Methods   # Methods       % Classes   # Classes
--------------------------------------------------------------------------------
100.00%     10 / 10     100.00%     2 / 2           100.00%	1 / 1


bootstrap.php
% Lines     # Lines     % Methods   # Methods       % Classes   # Classes
--------------------------------------------------------------------------------
75.00%      3 / 4       100.00%     NA              100.00%     NA
```

phploc ran on 02/12/2012 12:24:46 without test helpers:

```plain
phploc 1.6.4 by Sebastian Bergmann.

Directories:                                          2
Files:                                                8

Lines of Code (LOC):                                633
  Cyclomatic Complexity / Lines of Code:           0.04
Comment Lines of Code (CLOC):                       248
Non-Comment Lines of Code (NCLOC):                  385

Namespaces:                                           2
Interfaces:                                           0
Classes:                                              3
  Abstract:                                           3 (100.00%)
  Concrete:                                           0 (0.00%)
  Average Class Length (NCLOC):                     121
Methods:                                             20
  Scope:
    Non-Static:                                      20 (100.00%)
    Static:                                           0 (0.00%)
  Visibility:
    Public:                                           6 (30.00%)
    Non-Public:                                      14 (70.00%)
  Average Method Length (NCLOC):                     18
  Cyclomatic Complexity / Number of Methods:       2.75

Anonymous Functions:                                  1
Functions:                                            0

Constants:                                            1
  Global constants:                                   1
  Class constants:                                    0

Tests:
  Classes:                                            3
  Methods:                                           12
```

---

phploc ran on 02/12/2012 12:28:54 with test helpers:

```plain
phploc 1.6.4 by Sebastian Bergmann.

Directories:                                          3
Files:                                               12

Lines of Code (LOC):                                751
  Cyclomatic Complexity / Lines of Code:           0.03
Comment Lines of Code (CLOC):                       276
Non-Comment Lines of Code (NCLOC):                  475

Namespaces:                                           3
Interfaces:                                           0
Classes:                                              7
  Abstract:                                           3 (42.86%)
  Concrete:                                           4 (57.14%)
  Average Class Length (NCLOC):                      62
Methods:                                             28
  Scope:
    Non-Static:                                      28 (100.00%)
    Static:                                           0 (0.00%)
  Visibility:
    Public:                                          10 (35.71%)
    Non-Public:                                      18 (64.29%)
  Average Method Length (NCLOC):                     15
  Cyclomatic Complexity / Number of Methods:       1.88

Anonymous Functions:                                  1
Functions:                                            0

Constants:                                            1
  Global constants:                                   1
  Class constants:                                    0

Tests:
  Classes:                                            3
  Methods:                                           12
```