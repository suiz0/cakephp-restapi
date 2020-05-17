<?php

namespace RestAPI\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public function initialize() 
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Authentication.Authentication');
    }

    public function parseResult($data)
    {
        $this->set([
            'response' => $data,
            '_serialize' => 'response'
        ]);
    }
}
