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
namespace Vegas\Tests\Mvc\Controller;

use Phalcon\DI;
use Vegas\Tests\Stub\Models\FakeForm;
use Vegas\Tests\ApplicationTestCase;
use Vegas\Tests\Stub\Models\FakeModel;

class CrudTest extends ApplicationTestCase
{
    protected $model;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }
    public function setUp()
    {
        parent::setUp();

//        $config = $this->getDI()->get('config');
//        require $config->application->modulesDirectory . '/Test/Form/Fake.php';
        $this->prepareFakeObject();
    }

    public function tearDown()
    {
        foreach($_POST as $key => $value) {
            unset($_POST[$key]);
        }
        foreach (FakeModel::find() as $record) {
            $record->delete();
        }

        $this->getDI()->get('view')->enable();
    }

    private function prepareFakeObject()
    {
        $this->model = FakeModel::findFirst([[
            'fake_field' => base64_encode(date('Y-m-d'))
        ]]);

        if (!$this->model) {
            $this->model =  new FakeModel();
            $this->model->fake_field = base64_encode(date('Y-m-d'));
            $this->model->save();
        }
        $this->model->disableLazyLoading();
    }

    /**
     * @expectedException \Vegas\Crud\Exception\NotConfiguredException
     */
    public function testNotConfiguredCrud()
    {
        $this->getRequest()->setRequestMethod('GET');
        $this->handleUri('/test/brokencrud/new')->getContent();
    }

    public function testNew()
    {
        $this->getRequest()->setRequestMethod('GET');

        $form = new FakeForm();

        $res = $this->handleUri('/test/crud/new');
        $content = $res->getContent();

        $element = $form->get('fake_field')->render();
        $this->assertContains($element, $content);
        $this->assertContains('<form action="/test/crud/create/" method="POST" role="form">', $content);
    }

    /**
     * @expectedException \Vegas\Crud\Exception\PostRequiredException
     */
    public function testNotPostCreateResponse()
    {
        $this->handleUri('/test/crud/create');
    }

    public function testPostCreate()
    {
        $this->getRequest()
            ->setRequestMethod('POST')
            ->setPost('fake_field', base64_encode(date('Y-m-d')));

        $resp = $this->handleUri('/test/crud/create');
        $content = $resp->getContent();
        $this->assertNotEmpty($content);
    }

    public function testPostCreateResponse()
    {
        $this->getRequest()
            ->setRequestMethod('POST')
            ->setPost('fake_field', base64_encode(date('Y-m-d')));
        $response = $this->handleUri('/test/crud/create');

        $contentArray = json_decode($response->getContent(), true);

        $model = FakeModel::findById($contentArray['$id']);

        $this->assertInstanceOf(FakeModel::class, $model);
        $this->assertEquals(base64_encode(date('Y-m-d')), $model->fake_field);
        $this->assertEquals('afterCreate added content', $model->after_create_content);

        $model->delete();
    }

    public function testPostCreateException()
    {
        $this->config = $this->getDI()->get('config');
        $this->getRequest()
            ->setRequestMethod('POST')
            ->setPost('fake_field', '');

        $content = $this->handleUri('/test/crud/create')->getContent();
        $this->assertContains('Field is required', $content);
    }

    public function testEdit()
    {
        $config = $this->getDI()->get('config');
        $this->assertEquals($config, $this->config);
        $this->getRequest()->setRequestMethod('GET');

        $form = new FakeForm($this->model);
        $this->getDI()->get('scaffolding')->setForm($form);

        $url = $this->getDI()->get('url')->get(['for' => 'test/crud', 'action' => 'edit', 'params' => $this->model->getId()]);
        $content = $this->handleUri($url);
        $content = $content->getContent();

        $this->assertContains($form->get('fake_field')->render(['class' => 'form-control']), $content);
        $this->assertContains('<form action="/test/crud/update/'.$this->model->getId().'" method="POST" role="form">', $content);
    }

    /**
     * @expectedException \Vegas\Crud\Exception\PostRequiredException
     */
    public function testNotPostUpdateResponse()
    {
        $this->handleUri('/test/crud/update/'.$this->model->getId());
    }

    public function testPostUpdate()
    {
        $this->getRequest()
            ->setRequestMethod('POST')
            ->setPost('fake_field', base64_encode('foobar'));

        $content = $this->handleUri('/test/crud/update/' . $this->model->_id)->getContent();
        $this->assertEquals(json_encode($this->model->getId()), $content);
    }

    public function testPostUpdateResponse()
    {
        $this->getRequest()
            ->setRequestMethod('POST')
            ->setPost('fake_field', base64_encode('foobar'));

        $response = $this->handleUri('/test/crud/update/'.$this->model->getId());
        $contentArray = json_decode($response->getContent(), true);

        $model = FakeModel::findById($contentArray['$id']);

        $this->assertInstanceOf(FakeModel::class, $model);
        $this->assertEquals(base64_encode('foobar'), $model->fake_field);

        $model->delete();
    }

    public function testPostUpdateException()
    {
        $this->getRequest()
            ->setRequestMethod('POST')
            ->setPost('fake_field', '');

        $content = $this->handleUri('/test/crud/update/'.$this->model->getId())->getContent();
        $this->assertContains('Field is required', $content);
    }

    public function testIndex()
    {
        $this->getRequest()->setRequestMethod('GET');

        $content = $this->handleUri('/test/crud/index')->getContent();

        $this->assertContains('<th>Fake field index</th>', $content);
        $this->assertContains($this->model->fake_field, $content);
    }

    public function testShow()
    {
        $this->getRequest()->setRequestMethod('GET');

        $content = $this->handleUri('/test/crud/show/'.$this->model->getId())->getContent();

        $this->assertContains('<th>Fake field</th>', $content);
        $this->assertContains($this->model->fake_field, $content);
    }

    public function testDelete()
    {
        $this->model = FakeModel::findFirst();

        $this->getRequest()->setRequestMethod('GET');

        $this->handleUri('/test/crud/delete/'.$this->model->getId());
        $this->model = FakeModel::findById($this->model->getId());

        $this->assertFalse($this->model);
    }

    /**
     * @expectedException \MongoException
     */
    public function testDeleteException()
    {
        $this->getRequest()->setRequestMethod('GET');
        $this->handleUri('/test/crud/delete/RanDoMn0t1D4sUR3');
    }
}