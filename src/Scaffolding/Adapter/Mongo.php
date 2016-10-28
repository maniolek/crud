<?php
/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <aostrycharz@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\Crud\Scaffolding\Adapter;

use Phalcon\DI;
use Phalcon\DiInterface;
use Phalcon\Mvc\Collection\Manager;
use Vegas\Crud\Db\AdapterTrait;
use Vegas\Crud\Db\AdapterInterface;
use Vegas\Crud\Db\Exception\NoRequiredServiceException;
use Vegas\Crud\Scaffolding\AdapterInterface as ScaffoldingAdapterInterface;
use Vegas\Crud\Scaffolding\Exception\RecordNotFoundException;
use Vegas\Crud\Scaffolding;
use Vegas\Crud\Paginator\Adapter\Mongo as PaginatorAdapterMongo;

/**
 * Class Mongo
 *
 * Mongo adapter for scaffolding
 *
 * @package Vegas\DI\Scaffolding\Adapter
 */
class Mongo implements AdapterInterface, ScaffoldingAdapterInterface
{
    use AdapterTrait;

    /**
     * Scaffolding instance
     *
     * @var Scaffolding
     */
    protected $scaffolding;

    /**
     * Constructor
     * Verifies services required by Mongo
     */
    public function __construct()
    {
        $di = DI::getDefault();
        $this->verifyRequiredServices($di);
        $this->setupExtraServices($di);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveOne($id)
    {
        $this->ensureScaffolding();

        $this->scaffolding->getRecord()->disableLazyLoading();
        $record = call_user_func(array($this->scaffolding->getRecord(),'findById'),$id);

        if (!$record) {
            throw new RecordNotFoundException();
        }

        return $record;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaginator($page = 1, $limit = 10)
    {
        $this->ensureScaffolding();

        return new PaginatorAdapterMongo(array(
            'model' => $this->scaffolding->getRecord(),
            'limit' => $limit,
            'page' => $page
        ));
    }

    /**
     * Verifies required services for Mongo adapter
     *
     * @param DiInterface $di
     * @throws NoRequiredServiceException
     */
    public function verifyRequiredServices(DiInterface $di)
    {
        if (!$di->has('mongo')) {
            throw new NoRequiredServiceException();
        }
    }

    /**
     * Setups extra services (if not exist) required by mongo service
     *
     * @param DiInterface $di
     */
    public function setupExtraServices(DiInterface $di)
    {
        if (!$di->has('collectionManager')) {
            $di->set('collectionManager', function() {
                return new Manager();
            });
        }
    }


}
