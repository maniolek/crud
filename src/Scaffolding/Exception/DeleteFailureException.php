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

namespace Vegas\Crud\Scaffolding\Exception;

use Vegas\Crud\Scaffolding\Exception as ScaffoldingException;

/**
 * Class DeleteFailureException
 * @package Vegas\Crud\Scaffolding\Exception
 */
class DeleteFailureException extends ScaffoldingException
{
    /**
     * Exception default message
     */
    protected $message = 'Unable to delete record.';   
}
