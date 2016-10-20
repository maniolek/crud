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
namespace Vegas\Tests;

use Vegas\Crud\Db\Exception\NoRequiredServiceException;
use Vegas\Crud\Scaffolding\Exception\RecordNotFoundException;
use Vegas\Crud\Paginator\Adapter\Mongo;
use Vegas\Crud\Scaffolding;

class ScaffoldingTest extends ApplicationTestCase
{
    protected $scaffolding;
    protected $record;
    
    public function setUp()
    {
        $scaffolding = new Scaffolding(new Scaffolding\Adapter\Mongo());
        $scaffolding->setModelName('\Vegas\Tests\Stub\Models\FakeModel');
        $scaffolding->setFormName('\Vegas\Tests\Stub\Models\FakeForm');
        
        $this->scaffolding = $scaffolding;
        
        $record = new \Vegas\Tests\Stub\Models\FakeModel();
        $record->fake_field = 'test';
        $record->save();
        
        $this->record = $record;
    }

    public function testRequiredServicesVerification()
    {
        $di = \Phalcon\DI::getDefault();

        $emptyDI = new \Phalcon\DI\FactoryDefault();
        \Phalcon\DI::setDefault($emptyDI);

        $exception = null;
        try {
            new Scaffolding(new Scaffolding\Adapter\Mongo());
        } catch (NoRequiredServiceException $e) {
            $exception = $e;
        }
        $this->assertInstanceOf(NoRequiredServiceException::class, $exception);

        //reverts DI
        \Phalcon\DI::setDefault($di);
    }
    
    public function testGetRecord()
    {
        $fakeModel = new \Vegas\Tests\Stub\Models\FakeModel();
        
        $record = $this->scaffolding->getRecord();
        $this->assertEquals($fakeModel, $record);
        
        $this->assertNotEquals($fakeModel, $this->record);
    }
    
    public function testGetForm()
    {
        $fakeForm = new \Vegas\Tests\Stub\Models\FakeForm();
        
        $this->assertEquals($fakeForm, $this->scaffolding->getForm());
        
        $emptyRecord = $this->scaffolding->getRecord();
        $scaffoldForm = $this->scaffolding->getForm($emptyRecord);
        
        $this->assertEquals($fakeForm, $scaffoldForm);
        
        $notEmptyForm = new \Vegas\Tests\Stub\Models\FakeForm($this->record);
        
        $this->assertNotEquals($scaffoldForm, $notEmptyForm);
    }
    
    public function testDoRead()
    {
        $record = $this->scaffolding->doRead($this->record->getId());
        $this->assertEquals($this->record->getId(), $record->getId());
        
        try {
            $this->scaffolding->doRead(new \MongoId());
            throw new \Exception('Not this exception.');
        } catch (\Exception $ex) {
            $this->assertInstanceOf(RecordNotFoundException::class, $ex);
        }
        
        try {
            $this->scaffolding->doRead('not_existing_id');
            throw new \Exception('Not this exception.');
        } catch (\Exception $ex) {
            $this->assertInstanceOf('\MongoException', $ex);
        }
    }
    
    public function testDoCreate()
    {
        $values = array('fake_field' => 'test');
        
        $this->scaffolding->doCreate($values);
        $firstRecord = $this->scaffolding->getRecord();
        
        $this->scaffolding->doCreate($values);
        $secondRecord = $this->scaffolding->getRecord();
        
        $this->assertNotEquals($firstRecord->getId(), $secondRecord->getId());
    }
    
    public function testDoUpdate()
    {
        $values = array('fake_field' => 'testtest');

        $this->scaffolding->doUpdate($this->record->getId(), $values);
        $updatedRecordId = $this->scaffolding->getRecord()->getId();
        
        $this->assertEquals($this->record->getId(), $updatedRecordId);
    }
    
    public function testDoDelete()
    {
        $this->scaffolding->doDelete($this->record->getId());
        
        try {
            $this->scaffolding->doDelete($this->record->getId());
            throw new \Exception('Not this exception.');
        } catch (\Exception $ex) {
            $this->assertInstanceOf(RecordNotFoundException::class, $ex);
        }
    }
}
