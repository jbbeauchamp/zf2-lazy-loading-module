<?php

namespace ZFBook\Module\Listener\Server;

use ZFBook\Module\Listener\AbstractListener as BaseListener,
    Zend\Http\PhpEnvironment\Request,
    ZFBook\Module\ModuleEvent;

class AbstractListener extends BaseListener
{
    protected $request;
    
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
    
    public function getRequest()
    {
        if(!$this->request) {
            $this->request = new Request();
        }
        return $this->request;
    }
    
    /**
     *
     * @param ModuleEvent $e
     * @return string 
     */
    public function environment(ModuleEvent $e)
    {
    	$parameter = $e->getParameterEnvironnement();
        return $this->getRequest()->server()->get($parameter);
    }
}
