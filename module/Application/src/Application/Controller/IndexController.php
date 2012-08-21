<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return array(
            'modules' => $this->getServiceLocator()->get('ModuleManager')->getModules()
        );
    }
}
