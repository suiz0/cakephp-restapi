<?php

namespace Kinbalam\RestAPI;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Http\MiddlewareQueue;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;

/**
 * Plugin for RestAPI
 */
class Plugin extends BasePlugin implements AuthenticationServiceProviderInterface
{
    public function getAuthenticationService(ServerRequestInterface $request, ResponseInterface $response)
    {
        $service = new AuthenticationService();

        $service->loadIdentifier('Authentication.JwtSubject', Configure::read('RestAPI.auth.identity'));
        $service->loadAuthenticator('Authentication.Jwt', Configure::read('RestAPI.auth.jwt'));

        return $service;
    }

    public function middleware($middlewareQueue)
    {
        $authentication = new AuthenticationMiddleware($this);
        $middlewareQueue->add($authentication);

        return $middlewareQueue;
    }

}
