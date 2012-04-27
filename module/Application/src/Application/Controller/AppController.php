<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel,
	Zend\Mvc\Controller\ActionController;

class AppController extends ActionController
{
    public function appAction()
    {
        return array(
            'modules' => $this->getLocator()->get('ZFMLL\Module\Manager')->getModules()
        );
    }
    
    public function adminloadAction()
    {
    }
    
    public function cronloadAction()
    {
    }
}
