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
namespace Vegas\Crud\Paginator\Adapter\Exception;

use Vegas\Crud\Paginator\Adapter\Exception as AdapterException;

/**
 * Class DbNotSetException
 * @package Vegas\Crud\Paginator\Adapter\Exception
 */
class DbNotSetException extends AdapterException
{
    /**
     * Exception default message
     *
     * @var string
     */
    protected $message = 'You need to set mongo db for pagination.';
}
