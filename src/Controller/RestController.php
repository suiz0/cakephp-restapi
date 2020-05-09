<?php
namespace RestAPI\Controller;

use RestAPI\Controller\AppController as BaseController;

class RestController extends BaseController {
    public $Model;

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $result = $this->Model->find('all');
        $this->parseResult($result);
    }

    public function view($id)
    {
        $result = $this->Model->get($id);

        if($result)
        {
            $this->parseResult($result);
        }
    }

    public function delete($id)
    {
        $entity = $this->Model->get($id);
        if($entity) {
            if($this->Model->delete($entity))
            {
                $this->parseResult(["OK"]);
            }
        }
    }

    public function create()
    {
        $entity = $this->Model->newEntity($this->request->getData());

        if($this->Model->save($entity))
        {
            $this->parseResult($this->Model->get($entity->id));
        }
        else
        {
            throw new \Cake\Network\Exception\HttpException('Could not save record', 400);
        }
    }

    public function update($id)
    {
    }

}