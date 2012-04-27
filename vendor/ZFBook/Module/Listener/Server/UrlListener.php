<?php

namespace ZFBook\Module\Listener\Server;

use ZFBook\Module\ModuleEvent;

class UrlListener extends AbstractListener
{
	/**
     * Lister name
     * @var string
     */
    protected $name = 'url';
	
    /**
     * 
     * @param string $moduleName
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
    	if(isset($this->config['static'])) {
    		return $this->getRequest()->getRequestUri() == $this->config['static'];
    	}
    	else if(isset($this->config['regex'])) {
    		return preg_match('(^' . $this->config['regex'] . '$)', $this->getRequest()->getRequestUri());
    	}
        return false;
    }
    
    /**
     *
     * @param ModuleEvent $e
     * @return string 
     */
    public function environment(ModuleEvent $e)
    {
    	return $this->getRequest()->getRequestUri();
    }
}
