# Vegas CMF Crud

## Getting started

Add to composer.json file:

```
"require": {
    "vegas-cmf/crud" : "v2.0.0",
    "vegas-cmf/assets" : "v2.0",
    "vegas-cmf/forms" : "v2.0",
    "vegas-cmf/validation" : "2.*",
    "vegas-cmf/filter" : "2.*"
}
```

Crud is working with Scaffolding service which should be set as shared instance.

```php
namespace App\Shared;

use Phalcon\DiInterface;
use Vegas\Crud\Scaffolding\Adapter\Mongo;
use Vegas\Di\Injector\SharedServiceProviderInterface;

/**
 * Class Mongo
 * @package App\Shared
 */
class Scaffolding implements SharedServiceProviderInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'scaffolding';
    }
    /**
     * {@inheritdoc}
     */
    public function getProvider(DiInterface $di)
    {
        return function() use ($di)
        {
            return new \Vegas\Crud\Scaffolding(new Mongo());
        };
    }
}
```

Scaffolding constructor as the first argument takes an adapter. We've prepared so far adapters for:

- \Vegas\Crud\Scaffolding\Adapter\Mongo
- \Vegas\Crud\Scaffolding\Adapter\Mysql

Scaffolding is based on model and form class which has to exists in project.

### Example form class

```php
namespace Client\Form;

use Vegas\Forms\Element\Text;
use Vegas\Validation\Validator\PresenceOf;

/**
 * Class Profile
 * @package Client\Form
 */
class Profile extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $field = new Text('name');
        $field->addValidator(new PresenceOf());
        $this->add($field);
    }
}
```

### Example model class

```php
namespace Client\Model;

use \Vegas\ODM\Collection;

/**
 * Class Profile
 * @package Client\Model
 */
class Profile extends Collection
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSource()
    {
        return 'profile';
    }

}
```

### Example controller class

```php
namespace Client\Controller;

use Phalcon\Mvc\View;
use Vegas\Crud\CrudAbstract;

class ProfileController extends CrudAbstract
{
    protected $modelName = \Client\Model\Profile::class;
    protected $formName = \Client\Form\Profile::class;

    protected $indexFields = ['name' => 'Client name'];
    protected $showFields = ['name' => 'Client name'];
}
```

### Example routing
Note: Each route heading to crud page must have a name specified.

 ```php
 $router->add('/crud/:action/:params', [
     'module' => 'Crud',
     'controller' => 'Client\Profile',
     'action' => 1,
     'params' => 2
 ])->setName('crud/index');
 ```

### Default actions and views
We've prepared default views for actions of CrudAbstract class, they are located at vendor/vegas-cmf/crud/src/View/ directory.
A CrudAbstract class is obligated to find this views when a custom view won't be found. For the custom view, you can
easily grab them and copy to your module view directory. There is defined a pattern of the path to a controller view
directory. For ProfileController described above, the view directory for this controller would be Crud/View/Client/Profile/
So here we have 'Crud' as a module name, 'Client/Profile' as controller namespace with a name.

Example View structure is listed here:
```
View/
    Client/
        Profile/
            index.volt
            new.volt
            show.volt
            edit.volt
```