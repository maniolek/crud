<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Controller;

use Test\Model\Test;
use Vegas\Mvc\ControllerAbstract;

class IndexController extends ControllerAbstract
{
    public function indexAction()
    {
        $test = new Test();
    }

    public function ipAction()
    {
        return $this->jsonResponse(['test' => 1]);
    }
}