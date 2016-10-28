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
namespace Vegas\Crud\Db;

use Phalcon\DiInterface;
use Phalcon\Mvc\Collection\Manager;
use Vegas\Crud\Db\Exception\NoRequiredServiceException;
use Vegas\Crud\Scaffolding;

/**
 * Trait AdapterTrait
 *
 * Should be use for classes that use Mongo database adapter
 *
 * @package Vegas\Db\Adapter\Mongo
 */
trait AdapterTrait
{
    /**
     * Determines if scaffolding has been set
     *
     * @return bool
     * @throws \Vegas\Crud\Scaffolding\Exception\MissingScaffoldingException
     */
    protected function ensureScaffolding()
    {
        if (!$this->scaffolding instanceof Scaffolding) {
            throw new Scaffolding\Exception\MissingScaffoldingException();
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function setScaffolding(Scaffolding $scaffolding) {
        $this->scaffolding = $scaffolding;

        return $this;
    }
}
