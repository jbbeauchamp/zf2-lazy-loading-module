<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class AppController extends AbstractActionController
{
    public function appAction()
    {
        return array(
            'modules' => $this->getServiceLocator()->get('ModuleManager')->getModules()
        );
    }
    
    public function adminloadAction()
    {
    }
    
    public function cronloadAction()
    {
    }
}
