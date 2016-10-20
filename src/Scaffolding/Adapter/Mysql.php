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
use Phalcon\Paginator\Adapter\Model as PaginatorAdapterModel;
use Vegas\Crud\Db\AdapterInterface;
use Vegas\Crud\Db\Exception\NoRequiredServiceException;
use Vegas\Crud\Scaffolding\AdapterInterface as ScaffoldingAdapterInterface;
use Vegas\Crud\Scaffolding\Exception\MissingScaffoldingException;
use Vegas\Crud\Scaffolding\Exception\RecordNotFoundException;
use Vegas\Crud\Scaffolding;

/**
 * Class Mysql
 *
 * Mysql adapter for scaffolding
 *
 * @package Vegas\Crud\Scaffolding\Adapter
 */
class Mysql implements AdapterInterface, ScaffoldingAdapterInterface
{
    /**
     * Scaffolding instance
     *
     * @var Scaffolding
     */
    protected $scaffolding;

    /**
     * Constructor
     */
    public function __construct()
    {
        $di = DI::getDefault();
        $this->verifyRequiredServices($di);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieveOne($id)
    {
        $this->ensureScaffolding();

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

        return new PaginatorAdapterModel(array(
            'data' => (object) call_user_func(array($this->scaffolding->getRecord(), 'find')),
            'limit' => $limit,
            'page' => $page
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setScaffolding(Scaffolding $scaffolding) {
        $this->scaffolding = $scaffolding;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function verifyRequiredServices(DiInterface $di)
    {
        if (!$di->has('mysql')) {
            throw new NoRequiredServiceException();
        }
    }

    /**
     * Determines if scaffolding has been set
     *
     * @return bool
     * @throws \Vegas\Crud\Scaffolding\Exception\MissingScaffoldingException
     */
    protected function ensureScaffolding()
    {
        if (!$this->scaffolding instanceof Scaffolding) {
            throw new MissingScaffoldingException();
        }

        return true;
    }
}
