<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel,
	Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        return array(
            'modules' => $this->getServiceLocator()->get('ModuleManager')->getModules()
        );
    }
}
