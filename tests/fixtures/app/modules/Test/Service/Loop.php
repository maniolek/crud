<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Service;

use Phalcon\DI\InjectionAwareInterface;
use Vegas\Di\InjectionAwareTrait;

class Loop implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * @var Loop
     * @inject(class=\Test\Service\Loop)
     */
    protected $loop;

    public function bar()
    {
        echo 1;
    }
}