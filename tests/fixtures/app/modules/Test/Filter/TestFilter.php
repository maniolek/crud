<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Filter;

use Vegas\Mvc\Router\PluginInterface;
use Vegas\Mvc\Router\Route;

class TestFilter implements PluginInterface
{

    /**
     * @param $uri
     * @return mixed
     */
    public function beforeMatch($uri, \Vegas\Mvc\Router\Route $route)
    {
        // TODO: Implement beforeMatch() method.
    }

    /**
     * @param $uri
     * @param Route $route
     * @return mixed
     */
    public function afterMatch($uri, \Vegas\Mvc\Router\Route $route)
    {
        // TODO: Implement afterMatch() method.
    }
}