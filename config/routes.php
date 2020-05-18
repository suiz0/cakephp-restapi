<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use Cake\Core\Configure;

Router::plugin(
    'Kinbalam/RestAPI',
    ['path' => Configure::read('RestAPI.path')],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->setExtensions(['json']);

        $routes->get('/', [
            'controller' => 'Entities', 'action' => 'index'
        ]);

        $routes->get('/:id', [
            'controller' => 'Entities', 'action' => 'view'
        ])
        ->setPass(['id']);

        $routes->post('/', [
            'controller' => 'Entities', 'action' => 'create'
        ]);

        $routes->delete('/:id', [
            'controller' => 'Entities', 'action' => 'delete'
        ])->setPass(['id']);

        $routes->put('/:id', [
            'controller' => 'Entities', 'action' => 'update'
        ])->setPass(['id']);
    }
);
