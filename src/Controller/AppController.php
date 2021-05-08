<?php

namespace Kinbalam\RestAPI\Controller;

use App\Controller\AppController as BaseController;
use \Cake\Event\Event;
use Kinbalam\RestAPI\Model\Domain\Configuration;

class AppController extends BaseController
{
    protected $actions = null;
    protected $user;

    public function initialize() 
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        if(Configuration::IsAuthEnabled()) {
            $this->loadComponent('Authentication.Authentication');
        }
            
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);

        if(isset($this->Authentication)) {
            $this->user = $this->Authentication->getResult()->getData();
        }
    }

    protected function defineAction($method, $url, $rel) {
        $this->actions[] = array(
            'method' => $method,
            'url' => $url,
            'rel' => $rel
        );
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
            $response = $this->data;
            if(isset($this->actions)) {
                $collection = $this->data->toArray();
                if($collection && count($collection) > 0) {
                    if(is_numeric(array_keys($collection)[0])) {
                        $response = [];
                        foreach($collection as $data) {
                            $response[] = array_merge($data->toArray(), array ('__links'=>$this->parseActions($data->toArray())));
                        }
                    } else {
                        $response = array_merge($collection, array('__links'=>$this->parseActions($collection)));
                    }
                }
            }

            $this->set([
                'response' => $response,
                '_serialize' => 'response'
            ]);
        }
    }

    private function parseActions($data) {
        $parsedActions = [];
        foreach($this->actions as $action) {
            foreach($data as $key => $value) {
                $action = str_replace('%' . $key . '%', $value, $action);
            }

            $parsedActions[] = $action;
        }

        return $parsedActions;
    }
}
