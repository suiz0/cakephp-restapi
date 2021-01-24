<?php
namespace Kinbalam\RestAPI\Controller;

use Kinbalam\RestAPI\Controller\AppController as BaseController;

class RestEntitiesController extends BaseController {
    public $Model;

    public function initialize()
    {
        parent::initialize();
        $this->configureModel($this->request->getParam('resource'));
    }

    public function index()
    {
        $this->defineAction('put', '/entites/' . $this->Model->table() . '/%id%', 'update');
        $this->defineAction('delete', '/entites/' . $this->Model->table() . '/%id%', 'delete');
        $this->defineAction('get', '/entites/' . $this->Model->table() . '/%id%', 'view');
        $this->defineAction('post', '/entites/' . $this->Model->table(), 'create');
        $this->data = $this->Model->find('all');
    }

    public function view($id)
    {
        $this->defineAction('put', '/entites/' . $this->Model->table() . '/%id%', 'update');
        $this->defineAction('delete', '/entites/' . $this->Model->table() . '/%id%', 'delete');
        
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
    protected function configureModel($resource)
    {
        $this->Model = $this->loadModel($resource);
    }
}