<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Component;


use Test\Service\FakeService;
use Vegas\Mvc\Component\ComponentAbstract;

class InjectorComponent extends ComponentAbstract
{
    protected $initCount = 0;

    /**
     * @var FakeService
     * @inject(class=\Test\Service\FakeService)
     */
    public $fakeService;

    public function initialize()
    {
        $increment = ++$this->initCount;
        $this->setViewParam('initCounter', $increment);

        parent::initialize();
    }

    public function datagrid()
    {
        return $this->getRender('datagrid');
    }
}