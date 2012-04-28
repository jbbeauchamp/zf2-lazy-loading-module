<?php

namespace ZFMLL\Module\Listener\Server;

use ZFMLL\Module\ModuleEvent;

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
        return $this->getRequest()->uri()->getHost() == $this->config;
    }
    
    /**
     *
     * @param ModuleEvent $e
     * @return string 
     */
    public function environment(ModuleEvent $e)
    {
    	return $this->getRequest()->uri()->getHost();
    }
}
