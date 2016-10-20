<?php
use Vegas\Tests\Mvc\Router\TestAfterPlugin;
use Vegas\Tests\Mvc\Router\TestPlugin;
/** @var \Vegas\Mvc\Router $router */
$router->add('/test', [
    'module' => 'Test',
    'controller' => 'Frontend\Index',
    'action' => 'index'
])
    ->pushFilter(
        new \Test\Filter\TestFilter()
    )
    ->beforeMatch(function($uri, $route) {
        echo "BeforeMatch!";
        return true;
    });

$router->add('/test-view', [
    'module' => 'Test',
    'controller' => 'Index',
    'action' => 'index'
]);

$router->add('/test-json-view', [
    'module' => 'Test',
    'controller' => 'Index',
    'action' => 'ip'
]);


$router->add('/test/brokencrud/:action/:params', [
        'module' => 'Test',
        'controller' => 'Backend\BrokenCrud',
        'action' => 1,
        'params' => 2
    ]
)->setName('test/brokencrud');

$router->add('/test/crud/:action/:params', [
        'module' => 'Test',
        'controller' => 'Backend\Crud',
        'action' => 1,
        'params' => 2
    ]
)->setName('test/crud');