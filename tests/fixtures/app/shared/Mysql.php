<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace App\Shared;

use Vegas\Di\Injector\SharedServiceProviderInterface;

class Mysql implements SharedServiceProviderInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'mysql';
    }

    /**
     * @param \Phalcon\DiInterface $di
     * @return mixed
     */
    public function getProvider(\Phalcon\DiInterface $di)
    {
        return function() use ($di) {

            return new \Phalcon\Db\Adapter\Pdo\Mysql($di->get('config')->mysql->toArray());
        };
    }
}