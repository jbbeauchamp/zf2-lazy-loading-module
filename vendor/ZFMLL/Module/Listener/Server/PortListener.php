<?php

namespace ZFMLL\Module\Listener\Server;

class PortListener extends AbstractListener
{
	/**
     * Lister name
     * @var string
     */
    protected $name = 'port';
	
    /**
     * 
     * @param string $moduleName
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
        return $this->getRequest()->server()->get('SERVER_PORT') == $this->config;
    }
}
