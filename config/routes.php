<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'RestAPI',
    ['path' => '/api/:resource'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->setExtensions(['json']);

        $routes->get('/', [
            'controller' => 'Resources', 'action' => 'index'
        ])
        ->setPass(['resource']);

        $routes->get('/:id', [
            'controller' => 'Resources', 'action' => 'view'
        ])
        ->setPass(['resource','id']);
    }
);
