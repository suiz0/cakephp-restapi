<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use Cake\Core\Configure;

Router::plugin(
    'RestAPI',
    ['path' => Configure::read('RestAPI.path')],
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

        $routes->post('/', [
            'controller' => 'Resources', 'action' => 'add'
        ])->setPass(['resource']);
    }
);
