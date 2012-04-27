<?php

namespace ZFBook\Module\Listener\Server;

use ZFBook\Module\ModuleEvent;

class DomainListener extends AbstractListener
{
	/**
     * Lister name
     * @var string
     */
    protected $name = 'domain';
	
    /**
     * 
     * @param string $moduleName
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
        return $this->getRequest()->server()->get('SERVER_NAME') == $this->config;
    }
    
    /**
     *
     * @param ModuleEvent $e
     * @return string 
     */
    public function environment(ModuleEvent $e)
    {
    	return $this->getRequest()->server()->get('SERVER_NAME');
    }
}
