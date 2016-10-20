<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Model;

use Test\Service\FakeService;

class InjectorTest
{
    /**
     * @var FakeService
     * @inject(class=\Test\Service\FakeService)
     */
    public $fakeService;

}