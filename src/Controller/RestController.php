<?php
namespace Kinbalam\RestAPI\Controller;

use Kinbalam\RestAPI\Controller\AppController as BaseController;

class RestController extends BaseController {
    public $Model;

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->data = $this->Model->find('all');
    }

    public function view($id)
    {
        $result = $this->Model->get($id);

        if($result)
        {
            $this->data = $result;
        }
    }

    public function delete($id)
    {
        $this->request->allowMethod(['delete']);
        $entity = $this->Model->get($id);
        if($entity) {
            if($this->Model->delete($entity))
            {
                $this->data = ["OK"];
            }
        }
    }

    public function create()
    {
        $this->request->allowMethod(['post']);
        $entity = $this->Model->newEntity($this->request->getData());

        if($this->Model->save($entity))
        {
            $this->data = $this->Model->get($entity->id);
        }
        else
        {
            throw new \Cake\Network\Exception\HttpException('Could not save record', 400);
        }
    }

    public function update($id)
    {
        $this->request->allowMethod(['put']);
        $entity = $this->Model->get($id);

        if($entity) 
        {
            $entity = $this->Model->patchEntity($entity, $this->request->getData());
            if($this->Model->save($entity))
            {
                $this->data = $entity;
            }
        }
    }

}