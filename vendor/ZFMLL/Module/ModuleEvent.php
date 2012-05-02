<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module;

use Zend\Module\ModuleEvent as BaseEvent;

class ModuleEvent extends BaseEvent
{
    /**
     * Listener to use
     * @var string
     */
    protected $parameterListener;
    
    /**
     * Parameter to get
     * @var string
     */
    protected $parameterEnvironnement;
	
    /**
     * Get listener to use
     * @param string $parameterListener
     */
    public function getParameterListener()
    {
    	return $this->parameterListener;
    }
    
    /**
     * Set listener to use
     * @param string $parameterListener
     */
    public function setParameterListener($parameterListener)
    {
    	$this->parameterListener = $parameterListener;
    	return $this;
    }
    
    /**
     * Get parameter listener
     */
    public function getParameterEnvironnement()
    {
    	return $this->parameterEnvironnement;
    }
    
    /**
     * Set parameter listener
     * @param string $parameterEnvironnement
     */
    public function setParameterEnvironnement($parameterEnvironnement)
    {
    	$this->parameterEnvironnement = $parameterEnvironnement;
    	return $this;
    }
}