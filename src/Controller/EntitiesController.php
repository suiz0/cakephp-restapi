<?php

namespace Kinbalam\RestAPI\Controller;

use Kinbalam\RestAPI\Controller\RestController as BaseController;

class EntitiesController extends BaseController 
{
    public function initialize()
    {
        parent::initialize();
        $this->configureModel($this->request->getParam('resource'));
    }

    protected function configureModel($resource)
    {
        $this->Model = $this->loadModel($resource);
    }
}