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

use Vegas\Forms\Element\Text;
use Vegas\Forms\Form;
use Vegas\Validation\Validator\PresenceOf;

class FakeForm extends Form
{
    public function initialize()
    {
        $field = new Text('fake_field');
        $field->addValidator(new PresenceOf());
        $field->setAttribute('class', 'form-control');
        $this->add($field);
    }
}
