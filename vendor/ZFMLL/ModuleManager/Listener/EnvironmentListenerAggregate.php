<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\ModuleManager\Listener;

use Zend\EventManager\EventManagerInterface,
    Zend\ModuleManager\Listener\DefaultListenerAggregate,
    Zend\EventManager\EventCollection;

class EnvironmentListenerAggregate extends DefaultListenerAggregate
{
    /**
     * Attach one or more listeners
     *
     * @param EventCollection $events
     * @return DefaultListenerAggregate
     */
    public function attach(EventManagerInterface $events)
    {	
        $options = $this->getOptions();
        $lazyLoading = $options->getLazyLoading();
        
        $listenerManager = new ListenerManager($lazyLoading);
        $this->listeners[] = $events->attach('loadModuleAuth', array($listenerManager, 'authorize'));
        $this->listeners[] = $events->attach('loadModuleAuth.argument', array($listenerManager, 'argument'));
        
        return parent::attach($events);
    }
}