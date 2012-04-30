<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module;

use Zend\Module\ModuleEvent as BaseEvent;

class ModuleEvent extends BaseEvent
{
    protected $parameterEnvironnement;
	
    public function getParameterEnvironnement()
    {
    	return $this->parameterEnvironnement;
    }
    
	public function setParameterEnvironnement($parameterEnvironnement)
    {
    	return $this->parameterEnvironnement = $parameterEnvironnement;
    }
}