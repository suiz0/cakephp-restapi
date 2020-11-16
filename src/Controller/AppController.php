<?php

namespace Kinbalam\RestAPI\Controller;

use App\Controller\AppController as BaseController;
use \Cake\Event\Event;

class AppController extends BaseController
{
    public function initialize() 
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeRender(Event $event) {
        parent::beforeRender($event);

        if(isset($this->data)) {
            $this->parseResult();
        }
    }

    public function parseResult()
    {
        if(isset($this->data)) {
            $this->set([
                'response' => $this->data,
                '_serialize' => 'response'
            ]);
        }
    }
}
