<?php

namespace ZFMLL\Module\Listener\Server;

class HttpsListener extends AbstractListener
{
	/**
     * Lister name
     * @var string
     */
    protected $name = 'https';
	
    /**
     * 
     * @param string $moduleName
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
        return $this->getRequest()->server()->get('HTTPS') != $this->config;
    }
}
