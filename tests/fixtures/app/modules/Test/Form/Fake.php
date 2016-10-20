<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniolek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Form;

use Vegas\Forms\Element\Text;
use Vegas\Validation\Validator\PresenceOf;

/**
 * Class Fake
 * @package Home\Model
 */
class Fake extends \Vegas\Forms\Form
{
    public function initialize()
    {
        $name = new Text('name');
        $name->setLabel('Name');
        $name->addValidators([
            new PresenceOf([
                'message' => 'The name is required'
            ])
        ]);
        $this->add($name);

    }

}