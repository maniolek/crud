<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace App\Initializer;

use Vegas\Crud\Tags as CrudTags;
use App\View\Extension\ToStringFilter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Vegas\Mvc\Application\InitializerInterface;

class Crud implements InitializerInterface
{

    /**
     * @param \Phalcon\DiInterface $di
     * @return mixed
     */
    public function initialize(\Phalcon\DiInterface $di)
    {
        $di->set('crudTags', function() {
            return new CrudTags();
        });
    }
}