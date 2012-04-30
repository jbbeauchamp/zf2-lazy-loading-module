<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener;

use Zend\Module\Listener\DefaultListenerAggregate,
    Zend\EventManager\EventCollection,
    Zend\Module\Listener\ConfigMerger;

class EnvironmentListenerAggregate extends DefaultListenerAggregate
{
    /**
     * Attach one or more listeners
     *
     * @param EventCollection $events
     * @return DefaultListenerAggregate
     */
    public function attach(EventCollection $events)
    {	
    	// get lazy loading config
        $options = $this->getOptions();
        $lazyLoading = $options->getLazyLoading();
        
        $getoptListener = new Environment\GetoptListener($lazyLoading);
        $sapiListener = new Environment\SapiListener($lazyLoading);
		
        $this->listeners[] = $events->attach('loadModuleAuth', array($getoptListener, 'authorize'));
        $this->listeners[] = $events->attach('loadModuleAuth', array($sapiListener, 'authorize'));

        $this->listeners[] = $events->attach('routeModule.environment', array($getoptListener, 'environment'));
        $this->listeners[] = $events->attach('routeModule.environment', array($sapiListener, 'environment'));
            
        $this->listeners[] = $events->attach('loadModuleAuth', array(new Server\RemoteAddrListener($lazyLoading), 'authorize'));
        $this->listeners[] = $events->attach('loadModuleAuth', array(new Server\HttpsListener($lazyLoading), 'authorize'));
        $this->listeners[] = $events->attach('loadModuleAuth', array(new Server\PortListener($lazyLoading), 'authorize'));
        $this->listeners[] = $events->attach('loadModuleAuth', array(new Server\DomainListener($lazyLoading), 'authorize'));
        $this->listeners[] = $events->attach('loadModuleAuth', array(new Server\UrlListener($lazyLoading), 'authorize'));
        
        return parent::attach($events);
    }

    /**
     * Get the config merger.
     *
     * @return ConfigMerger
     */
    public function getConfigListener()
    {
        if (!$this->configListener instanceof ConfigMerger) {
            $this->setConfigListener(new ConfigListener($this->getOptions()));
        }
        return $this->configListener;
    }
}