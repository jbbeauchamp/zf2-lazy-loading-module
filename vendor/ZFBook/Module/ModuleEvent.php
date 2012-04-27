<?php

namespace ZFBook\Module;

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
