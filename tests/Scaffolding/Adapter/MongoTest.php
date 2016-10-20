<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\Tests\Scaffolding\Adapter;

use Vegas\Crud\Db\Exception\NoRequiredServiceException;
use Vegas\Tests\ApplicationTestCase;

class MongoTest extends ApplicationTestCase
{
    public function testShouldSetupOwnCollectionManager()
    {
        $collectionManager = $this->getDI()->get('collectionManager');

        $this->getDI()->remove('collectionManager');
        new \Vegas\Crud\Scaffolding\Adapter\Mongo();
        $this->assertInstanceOf('\Phalcon\Mvc\Collection\Manager', $this->getDI()->get('collectionManager'));


        $this->getDI()->set('collectionManager', $collectionManager, true);
    }

    public function testShouldThrowExceptionAboutMissingRequiredService()
    {
        $mongo = $this->getDI()->get('mongo');

        $this->getDI()->remove('mongo');

        $exception = null;
        try {
            new \Vegas\Crud\Scaffolding\Adapter\Mongo();
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf(NoRequiredServiceException::class, $exception);

        $this->getDI()->set('mongo', $mongo);
    }
}
 