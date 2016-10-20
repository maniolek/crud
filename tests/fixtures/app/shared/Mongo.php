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

class Mongo implements SharedServiceProviderInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'mongo';
    }

    /**
     * @param \Phalcon\DiInterface $di
     * @return mixed
     */
    public function getProvider(\Phalcon\DiInterface $di)
    {
        return function() use ($di) {

            $mongoConfig = $di->get('config')->mongo->toArray();

            if (isset($mongoConfig['dsn'])) {
                $hostname = $mongoConfig['dsn'];
                unset($mongoConfig['dsn']);
            } else {
                //obtains hostname
                if (isset($mongoConfig['host'])) {
                    $hostname = 'mongodb://' . $mongoConfig['host'];
                } else {
                    $hostname = 'mongodb://localhost';
                }
                if (isset($mongoConfig['port'])) {
                    $hostname .= ':' . $mongoConfig['port'];
                }
                //removes options that are not allowed in MongoClient constructor
                unset($mongoConfig['host']);
                unset($mongoConfig['port']);
            }
            $dbName = $mongoConfig['dbname'];
            unset($mongoConfig['dbname']);

            $mongo = new \MongoClient($hostname, $mongoConfig);
            return $mongo->selectDb($dbName);
        };
    }
}