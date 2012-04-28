<?php

namespace ZFMLL\Module;

use Zend\Module\Manager as BaseManager;

class Manager extends BaseManager
{
    /**
     * Load the provided modules.
     *
     * @triggers loadModules.pre
     * @triggers loadModules.post
     * @return Manager
     */
    public function loadModules()
    {
        if (true === $this->modulesAreLoaded) {
            return $this;
        }
		
        $modules = array();
    	foreach ($this->getModules() as $moduleName) {
            $auth = $this->loadModuleAuth($moduleName);
            if($auth) {
                $modules[] = $moduleName;
            }
        }
        $this->setModules($modules);
       	
        return parent::loadModules();
    }
	
    /**
     * Get auth to load a specific module by name.
     *
     * @param string $moduleName
     * @triggers loadModule.resolve
     * @triggers loadModule
     * @return mixed Module's Module class
     */
    public function loadModuleAuth($moduleName)
    {
        $event = $this->getEvent();
        $event->setModuleName($moduleName);
        
        $result = $this->events()->trigger(__FUNCTION__, $this, $event, function($r) {
            return !$r;
        });
        
        if(!$result->last()) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Get the module event
     *
     * @return ModuleEvent
     */
    public function getEvent()
    {
        if (!$this->event instanceof ModuleEvent) {
            $this->setEvent(new ModuleEvent);
        }
        return $this->event;
    }
}
