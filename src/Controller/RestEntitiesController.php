<?php
namespace Kinbalam\RestAPI\Controller;

use Kinbalam\RestAPI\Controller\AppController as BaseController;
use Cake\Event\Event;

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
            $event = new Event('RestAPI.Entities.beforeDelete', $this, [
                'data' => $entity,
                'table' => $this->Model->getTable()
            ]);
    
            $this->getEventManager()->dispatch($event);
            
            if(!$event->isStopped() && $this->Model->delete($entity))
            {
                $this->data = ["OK"];
            }
        } else {
            throw new \Cake\Network\Exception\HttpException('Record does not exist', 404);
        }
    }

    public function create()
    {
        $this->request->allowMethod(['post']);
        $entity = $this->Model->newEntity($this->request->getData());

        $event = new Event('RestAPI.Entities.beforeSave', $this, [
            'data' => $entity,
            'table' => $this->Model->getTable(),
            'action' => 'add',
            'user' => $this->user
        ]);

        $this->getEventManager()->dispatch($event);

        if($event->isStopped())
        {
            throw new \Cake\Network\Exception\HttpException('Could not save record', 500);
        }

        if(!empty($event->getResult()['data'])) {
            $entity = $event->getResult()['data'];
        }

        if($this->Model->save($entity)) 
        {
            $this->data = $this->Model->get($entity->id);
        } else {
            throw new \Cake\Network\Exception\HttpException('Could not save record', 500);
        }
    }

    public function update($id)
    {
        $this->request->allowMethod(['put']);
        $entity = $this->Model->get($id);
        if($entity)
        {
            $entity = $this->Model->patchEntity($entity, $this->request->getData());
            $event = new Event('RestAPI.Entities.beforeSave', $this, [
                'data' => $entity,
                'table' => $this->Model->getTable(),
                'action' => 'update',
                'user' => $this->user
            ]);
    
            $this->getEventManager()->dispatch($event);
            if($event->isStopped())
            {
                throw new \Cake\Network\Exception\HttpException('Could not save record', 500);
            }

            if(!empty($event->getResult()['data'])) {
                $entity = $event->getResult()['data'];
            }

            if($this->Model->save($entity)) {
                $this->data = $entity;
            } else {
                throw new \Cake\Network\Exception\HttpException('Could not save record', 500);
            }
        } else {
            throw new \Cake\Network\Exception\HttpException('Record does not exist', 404);
        }
    }

    protected function configureModel($resource)
    {
        $event = new Event('RestAPI.Entities.beforeLoadModel', $this, [
            'resource' => $resource
        ]);

        $this->getEventManager()->dispatch($event);
        if(!empty($event->getResult()['model'])) {
            $this->Model = $event->getResult()['model'];
        } else {
            $this->Model = $this->loadModel($resource);
        }
    }
}