<?php

namespace ZFMLL\Module\Listener;

use ZFMLL\Module\ModuleEvent;

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
	protected $lazyLoading;
	
	public function __construct($lazyLoading=null)
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
    public function authorize(ModuleEvent $e)
    {
        $moduleName = $e->getModuleName();
        $moduleName = strtolower($moduleName);
        $this->config = $this->getConfig($moduleName);
        if(!$this->lazyLoading->hasListener($moduleName, $this->name)) {
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
    
    public function getConfig($moduleName)
    {
    	return $this->lazyLoading->getListenerConfig($moduleName, $this->name);
    }
    
	public function getLazyLoading()
    {
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
