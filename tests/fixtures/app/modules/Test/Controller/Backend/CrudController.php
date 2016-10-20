<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Controller\Backend;

use Vegas\Crud\CrudAbstract;
use Vegas\Tests\Stub\Models\FakeForm;
use Vegas\Tests\Stub\Models\FakeModel;

class CrudController extends CrudAbstract
{
    protected $modelName = FakeModel::class;
    protected $formName = FakeForm::class;

    protected $showFields = [
        'fake_field' => 'Fake field',
        'created_at' => 'Created at'
    ];
    protected $indexFields = [
        'fake_field' => 'Fake field index',
        'created_at' => 'Created at index'
    ];

    public function initialize()
    {
        parent::initialize();
    }

    protected function afterCreate()
    {
        $record = $this->scaffolding->getRecord();
        $record->after_create_content = 'afterCreate added content';
        $record->save();

        return parent::afterCreate();
    }

    protected function afterSave()
    {
        return $this->jsonResponse($this->scaffolding->getRecord()->getId());
    }

    protected function afterDelete()
    {
        return $this->jsonResponse();
    }
}