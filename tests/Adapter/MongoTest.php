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

namespace Vegas\Tests\Adapter;

use Phalcon\DI;
use Vegas\Crud\Scaffolding\Adapter\Mongo;
use Vegas\DI\Scaffolding\Adapter;
use Vegas\Tests\ApplicationTestCase;


class MongoTest extends ApplicationTestCase
{
    public function testScaffoldingImplementsCorrectAbstract()
    {
        $di = $this->di;
        $di->set('scaffolding', new \Vegas\Crud\Scaffolding(new Mongo()));
        $this->assertInstanceOf('\Vegas\Crud\Scaffolding\AdapterInterface', $di->get('scaffolding')->getAdapter());
    }
}
