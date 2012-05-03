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
     * argument to get
     * @var string
     */
    protected $parameterArgument;

    /**
     * Get parameter listener
     */
    public function getParameterArgument()
    {
    	return $this->parameterArgument;
    }
    
    /**
     * Set argument environment listener
     * @param string $parameterEnvironnement
     */
    public function setParameterArgument($parameterArgument)
    {
    	$this->parameterArgument = $parameterArgument;
    	return $this;
    }
}