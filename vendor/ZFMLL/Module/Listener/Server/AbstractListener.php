<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener\Server;

use ZFMLL\Module\Listener\AbstractListener as BaseListener,
    Zend\Http\PhpEnvironment\Request,
    ZFMLL\Module\ModuleEvent;

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
