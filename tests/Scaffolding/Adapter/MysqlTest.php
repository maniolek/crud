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

use Phalcon\DI;
use Test\Model\Fake;
use Vegas\Crud\Scaffolding;
use Vegas\Tests\ApplicationTestCase;

class MysqlTest extends ApplicationTestCase
{
    public static function setUpBeforeClass()
    {
        $di = Di::getDefault();
        $di->get('mysql')->execute('DROP TABLE IF EXISTS fake ');
        $di->get('mysql')->execute(
            'CREATE TABLE fake(
            id int not null primary key auto_increment,
            fake_field varchar(250) null,
            created_at int null
            )'
        );
    }

    public static function tearDownAfterClass()
    {
        $di = self::$application->getDI(); //Di::getDefault();
        $di->get('db')->execute('DROP TABLE IF EXISTS fake ');
    }

    public function tearDown()
    {
        foreach (Fake::find() as $r) {
            $r->delete();
        }
    }

    public function testShouldThrowExceptionAboutMissingRequiredService()
    {
        $db = $this->getDI()->get('mysql');

        $this->getDI()->remove('mysql');

        $exception = null;
        try {
            new \Vegas\Crud\Scaffolding\Adapter\Mysql();
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\Vegas\Crud\Db\Exception\NoRequiredServiceException', $exception);

        $this->getDI()->set('mysql', $db);
    }

    public function testShouldThrowExceptionAboutMissingScaffolding()
    {
        $exception = null;
        try {
            $mysql = new \Vegas\Crud\Scaffolding\Adapter\Mysql();
            $mysql->retrieveOne(1);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\Vegas\Crud\Scaffolding\Exception\MissingScaffoldingException', $exception);
    }

    public function testShouldRetrieveRecordByItsId()
    {
        $mysql = new \Vegas\Crud\Scaffolding\Adapter\Mysql();
        $scaffolding = new Scaffolding($mysql);

        $scaffolding->setModelName('\Test\Model\Fake');
        $scaffolding->setFormName('\Test\Form\Fake');
        $created = $scaffolding->doCreate([
            'name' => 'fake',
            'fake_field' => 'fake'
        ]);
        $this->assertTrue($created);

        $this->assertInstanceOf('\Test\Model\Fake', $mysql->retrieveOne($scaffolding->getRecord()->getId()));
    }

    public function testShouldReturnValidPagination()
    {
        $mysql = new \Vegas\Crud\Scaffolding\Adapter\Mysql();
        $scaffolding = new Scaffolding($mysql);

        $scaffolding->setModelName('\Test\Model\Fake');
        $scaffolding->setFormName('\Test\Form\Fake');
        $scaffolding->doCreate([
            'name' => 'fake',
            'fake_field' => 'fake'
        ]);
        $scaffolding->doCreate([
            'name' => 'fake',
            'fake_field' => 'fake2'
        ]);

        $pagination = $mysql->getPaginator();
        $this->assertInstanceOf('\Phalcon\Paginator\Adapter\Model', $pagination);
        $this->assertInstanceOf('\stdClass', $pagination->getPaginate());
    }
}