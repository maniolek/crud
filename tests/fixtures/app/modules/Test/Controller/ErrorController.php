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

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $test = new Test();
        $this->view->testVar = 123;
    }

    public function ipAction()
    {
        $this->response->setHeader('Content-Type', 'application/json');
        $this->response->setJsonContent(['test' => 1]);
        return $this->response;
    }
}