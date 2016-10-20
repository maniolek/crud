<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace App\Shared;

use Vegas\Di\Injector\SharedServiceProviderInterface;

class ViewCache implements SharedServiceProviderInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'viewCache';
    }

    /**
     * @param \Phalcon\DiInterface $di
     * @return mixed
     */
    public function getProvider(\Phalcon\DiInterface $di)
    {
        return function() use ($di) {

            //Cache data for one day by default
            $frontCache = new \Phalcon\Cache\Frontend\Output([
                "lifetime" => 1
            ]);

            //File backend settings
            $cache = new \Phalcon\Cache\Backend\File($frontCache, [
                "cacheDir" => $di->get('config')->application->view->cacheDir
            ]);

            return $cache;
        };
    }
}