<?php
error_reporting(E_ALL);
//Test Suite bootstrap
include __DIR__ . "/../vendor/autoload.php";

use Phalcon\Loader;

define('TESTS_ROOT_DIR', dirname(__FILE__));
define('APP_ROOT', dirname(__FILE__) . '/fixtures');

$configArray = require_once APP_ROOT . '/app/config/config.php';

$_SERVER['HTTP_HOST'] = 'vegas.dev';
$_SERVER['REQUEST_URI'] = '/';

$di = new \Phalcon\Di\FactoryDefault();

$di->set('mongo', function() use ($configArray) {
    $mongo = new \MongoClient();
    return $mongo->selectDB($configArray['mongo']['db']);
}, true);

$di->set('db', function() use ($configArray) {
    $mysql = new \Phalcon\Db\Adapter\Pdo\Mysql($configArray['mysql']);
    return $mysql;
}, true);

$di->set('scaffolding', function() {
    return new \Vegas\Crud\Scaffolding(new \Vegas\Crud\Scaffolding\Adapter\Mongo([]));
}, true);

$di->set('url', function() {
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri('/');

    return $url;
}, true);

$di->set('collectionManager', function() {
    return new \Phalcon\Mvc\Collection\Manager();
}, true);

\Phalcon\Di::setDefault($di);