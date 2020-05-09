<?php

namespace RestAPI\Controller;

use RestAPI\Controller\AppController as BaseController;

class ResourcesController extends BaseController 
{
    private $model;

    public function initialize()
    {
        parent::initialize();
    }

    public function index($resource)
    {
        $this->configureModel($resource);

        $result = $this->model->find('all');
        $this->parseResult($result);
    }

    public function view($resource, $id)
    {
        $this->configureModel($resource);
        $result = $this->model->get($id);

        if($result)
        {
            $this->parseResult($result);
        }
    }

    public function add($resource)
    {
        $this->request->allowMethod(['post']);
        $this->configureModel($resource);

        $entity = $this->model->newEntity($this->request->getData());

        if($this->model->save($entity))
        {
            $this->parseResult($entity);
        }
        else
        {
            throw new \Cake\Network\Exception\HttpException('Could not save record', 400);
        }
    }

    public function delete()
    {
    }

    public function update() 
    {
    }

    protected function configureModel($resource)
    {
        $this->model = $this->loadModel($resource);
    }

    protected function parseResult($data)
    {
        $this->set([
            'data' => $data,
            '_serialize' => ['data']
        ]);
    }
}