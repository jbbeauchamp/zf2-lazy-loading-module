<?php

namespace ZFMLL\Module\Listener\Server;

class RemoteAddrListener extends AbstractListener
{
	/**
     * Lister name
     * @var string
     */
    protected $name = 'remote_addr';
	
    /**
     * 
     * @param string $moduleName
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
        if(is_string($this->config)) {
            $this->config = array($this->config);
        }
        return in_array($this->getRequest()->server()->get('REMOTE_ADDR'), $this->config);
    }
}
