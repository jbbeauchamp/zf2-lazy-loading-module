<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Mvc\Service;

use ZFMLL\ModuleManager\Listener\EnvironmentListenerAggregate;
use ZFMLL\ModuleManager\Listener\ListenerOptions;
use ZFMLL\ModuleManager\ModuleEvent;
use ZFMLL\ModuleManager\ModuleManager;

use Zend\ModuleManager\Listener\ServiceListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleManagerFactory implements FactoryInterface
{
    
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $configuration    = $serviceLocator->get('ApplicationConfiguration');
        $listenerOptions  = new ListenerOptions($configuration['module_listener_options']);
        $defaultListeners = new EnvironmentListenerAggregate($listenerOptions);
        $serviceListener  = new ServiceListener($serviceLocator);

        $events        = $serviceLocator->get('EventManager');
        $events->attach($defaultListeners);
        $events->attach($serviceListener);

        $moduleEvent   = new ModuleEvent;
        $moduleEvent->setParam('ServiceManager', $serviceLocator);

        $moduleManager = new ModuleManager($configuration['modules'], $events);
        $moduleManager->setEvent($moduleEvent);

        return $moduleManager;
    }
}
