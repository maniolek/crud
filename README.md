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
namespace Person\Model;

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