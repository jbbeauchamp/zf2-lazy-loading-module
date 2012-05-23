<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\ModuleManager\Listener;

use ZFMLL\ModuleManager\ModuleEvent,
    Zend\ModuleManager\ModuleEvent as BaseModuleEvent;

class ListenerManager
{
    /**
     * Listener broker
     * @var ListenerBroker
     */
    protected $listenerBroker;
	
	/**
     * Lazy loading config
     * @var Config\LazyLoading
     */
    protected $lazyLoading;

    /**
     *
     * @param array $lazyLoading 
     */
    public function __construct($lazyLoading = null)
    {
        if($lazyLoading) {
            $this->setLazyLoading($lazyLoading);
        }
    }
	
    /**
     * Authorize loading module listener
     * @param ModuleEvent $e
     * @return boolean 
     */
    public function authorize(BaseModuleEvent $e)
    {   
        $moduleName = $e->getModuleName();
        $moduleName = strtolower($moduleName);
        $listeners = $this->getLazyLoading()->getListenersModule($moduleName);
        foreach($listeners as $listener => $value) {
            $listenerObject = $this->load($listener);
            $listenerObject->setConfig($value);
            if(!$listenerObject->authorizeModule($moduleName)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Get parameter environment
     * @param ModuleEvent $e
     */
    public function argument(ModuleEvent $e)
    {
        $listeners = $this->getBroker()->getListeners();
        foreach($listeners as $listener) {
            if($listener instanceof EnvironmentHandler) {
                $argument = $listener->getArgument($e->getParameterArgument());
                if(null === $argument) {
                    continue;
                }
                return $argument;
            }
        }
    }
    
    /**
     * 
     * @param string $listenerName
     */
    public function load($listenerName, array $options = null)
    {
    	return $this->getBroker()->load($listenerName, $options);
    }
    
	/**
     * Set plugin broker instance
     * 
     * @param  string|ListenerBroker $broker 
     * @return 
     * @throws Exception\InvalidArgumentException
     */
    public function setBroker($broker)
    {
    	if (is_string($broker)) {
            if (!class_exists($broker)) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Invalid helper broker class provided (%s)',
                    $broker
                ));
            }
            $broker = new $broker();
        }
        if (!$broker instanceof ListenerBroker) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Listener broker must extend ZFMLL\ModuleManager\Listener\ListenerBroker; got type "%s" instead',
                (is_object($broker) ? get_class($broker) : gettype($broker))
            ));
        }
        $this->listenerBroker = $broker;
    }

    /**
     * Get listeners broker instance
     * 
     * @return ListenerBroker
     */
    public function getBroker()
    {
        if (null === $this->listenerBroker) {
            $this->setBroker(new ListenerBroker());
        }
        return $this->listenerBroker;
    }
    
    /**
     * Get lazy loading config
     * @return Config\LazyLoading 
     */
    public function getLazyLoading()
    {
        if(null === $this->lazyLoading) {
            $this->setLazyLoading(array());
        }
    	return $this->lazyLoading;
    }
    
    /**
     * Set lazy loading config
     * @param LazyLoading $lazyLoading 
     */
    public function setLazyLoading($lazyLoading)
    {
    	if(!$lazyLoading instanceof Config\LazyLoading) {
            $this->lazyLoading = new Config\LazyLoading($lazyLoading);
    	}
    	else {
            $this->lazyLoading = $lazyLoading;
    	}
    }
}