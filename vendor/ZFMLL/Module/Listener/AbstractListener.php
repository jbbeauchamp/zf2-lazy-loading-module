<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener;

use ZFMLL\Module\ModuleEvent,
    Zend\Module\ModuleEvent as BaseModuleEvent;

class AbstractListener implements AuthorizeHandler, EnvironmentHandler
{
	/**
     * Lister name, redefined in listener class
     * @var string
     */
    protected $name = '';
    
    /**
     * Current config
     * @var mixed
     */
    protected $config;
	
    /**
     * Authorize listener by module name
     * @var array()
     */
    protected $lazyLoading = array();

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
     * 
     * @param ModuleEvent $e
     * @return boolean 
     */
    public function authorize(BaseModuleEvent $e)
    {
        $moduleName = $e->getModuleName();
        $moduleName = strtolower($moduleName);
        $this->config = $this->getLazyLoadingConfig($moduleName);
        if(!$this->getLazyLoading()->hasListener($moduleName, $this->name)) {
            return true;
        }
        return $this->authorizeModule($moduleName);
    }
    
    public function authorizeModule($module)
    {
        return false;
    }
    
    public function environment(ModuleEvent $e)
    {
        return null;
    }
    
    public function getLazyLoadingConfig($moduleName)
    {
    	return $this->getLazyLoading()->getListenerConfig($moduleName, $this->name);
    }
    
    public function getLazyLoading()
    {
        if(!$this->lazyLoading) {
            $this->setLazyLoading(array());
        }
    	return $this->lazyLoading;
    }
    
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