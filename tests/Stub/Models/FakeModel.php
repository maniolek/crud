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
namespace Vegas\Tests\Stub\Models;

class FakeModel extends \Vegas\ODM\Collection
{
    public $fake_field;
    public $after_create_content;
    public $created_at;

    public function getSource()
    {
        return 'vegas_stubs';
    }

    public function readMapped($value)
    {
        return $this->{$value};
    }
}
 