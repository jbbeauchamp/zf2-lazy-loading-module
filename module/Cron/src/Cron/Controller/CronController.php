<?php

namespace Cron\Controller;

use Zend\View\Model\ViewModel,
	Zend\Mvc\Controller\ActionController;

class CronController extends AbstractController
{
    public function cronAction()
    {
        return array(
            'modules' => $this->getLocator()->get('ZFMLL\Module\Manager')->getModules()
        );
    }
}
