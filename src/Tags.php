<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniołek <mateusz.aniolek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Crud;
use Phalcon\Tag;
use Vegas\Crud\Tag\Pagination;
use Vegas\Mvc\Di;

/**
 * Class Tags
 * @package Vegas\Crud
 */
class Tags extends Tag
{
    public static function pagination($value)
    {
        $pagination = new Pagination(Di::getDefault());
        return $pagination->render($value);
    }
}
