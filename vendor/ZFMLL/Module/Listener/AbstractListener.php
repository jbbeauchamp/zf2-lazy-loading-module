<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener;

use ZFMLL\Module\ModuleEvent,
    Zend\Module\ModuleEvent as BaseModuleEvent;

abstract class AbstractListener implements AuthorizeHandler, EnvironmentHandler
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
     * Authorize loading module listener
     * @param ModuleEvent $e
     * @return boolean 
     */
    public function authorize(BaseModuleEvent $e)
    {   
        $moduleName = $e->getModuleName();
        $moduleName = strtolower($moduleName);
        if(!$this->getLazyLoading()->hasModuleInConfig($moduleName)) {
            $e->stopPropagation(true);
            return true;
        }
        if(!$this->getLazyLoading()->hasListener($moduleName, $this->name)) {
            return true;
        }
        $this->config = $this->getLazyLoadingConfig($moduleName);
        return $this->authorizeModule($moduleName);
    }
    
    /**
     * Authorize loading module
     * @param type $module
     * @return type 
     */
    public function authorizeModule($module)
    {
        return false;
    }
    
    /**
     * Get environnement value
     */
    public function environment(ModuleEvent $e)
    {
        return null;
    }
    
    /**
     * Get the lazy loading config for a module
     * @param type $moduleName
     * @return array 
     */
    public function getLazyLoadingConfig($moduleName)
    {
    	return $this->getLazyLoading()->getListenerConfig($moduleName, $this->name);
    }
    
    /**
     * Get lazy loading config
     * @return Config\LazyLoading 
     */
    public function getLazyLoading()
    {
        if(!$this->lazyLoading) {
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
    
    /**
     * Get listener name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}