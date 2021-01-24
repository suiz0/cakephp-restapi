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
            'controller' => 'RestEntities', 'action' => 'index'
        ]);

        $routes->get('/:id', [
            'controller' => 'RestEntities', 'action' => 'view'
        ])
        ->setPass(['id']);

        $routes->post('/', [
            'controller' => 'RestEntities', 'action' => 'create'
        ]);

        $routes->delete('/:id', [
            'controller' => 'RestEntities', 'action' => 'delete'
        ])->setPass(['id']);

        $routes->put('/:id', [
            'controller' => 'RestEntities', 'action' => 'update'
        ])->setPass(['id']);
    }
);
