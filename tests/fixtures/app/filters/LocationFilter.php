<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace App\Filter;

use Vegas\Mvc\Router\PluginInterface;

class LocationFilter implements PluginInterface
{

    /**
     * @param $uri
     * @return mixed
     */
    public function beforeMatch($uri, \Phalcon\Mvc\Router\Route $route)
    {
        // TODO: Implement beforeMatch() method.
    }

    /**
     * @param $uri
     * @param \Phalcon\Mvc\Router\Route $route
     * @return mixed
     */
    public function afterMatch($uri, \Phalcon\Mvc\Router\Route $route)
    {
        // TODO: Implement afterMatch() method.
    }
}