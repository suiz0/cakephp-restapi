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
        ]);

        $routes->get('/:id', [
            'controller' => 'Resources', 'action' => 'view'
        ])
        ->setPass(['id']);

        $routes->post('/', [
            'controller' => 'Resources', 'action' => 'create'
        ]);

        $routes->delete('/:id', [
            'controller' => 'Resources', 'action' => 'delete'
        ])->setPass(['id']);
    }
);
