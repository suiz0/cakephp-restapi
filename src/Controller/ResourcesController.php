<?php

namespace RestAPI\Controller;

use RestAPI\Controller\RestController as BaseController;

class ResourcesController extends BaseController 
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