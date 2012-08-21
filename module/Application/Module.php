<?php

namespace Application;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function init(ModuleManager $moduleManager)
    {
	$events = $moduleManager->getEventManager()->getSharedManager();
	$events->attach('application', MvcEvent::EVENT_ROUTE, array($this, 'initializeSomething'),-100);
    }
    
    public function initializeSomething(MvcEvent $e)
    {
        
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
