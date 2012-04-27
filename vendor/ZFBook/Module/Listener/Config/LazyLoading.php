<?php

namespace ZFBook\Module\Listener\Config;

class LazyLoading
{
	/**
	 * Authorize Listener by module name
	 * @var array
	 */
	protected $listeners = array();
	
	/**
     * @param  array|Traversable|null $options
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($options = null)
    {
        if (null !== $options) {
            $this->setFromArray($options);
        }
    }
	
	/**
     * @param  array|Traversable $options
     * @return void
     */
    public function setFromArray($options)
    {
        if (!is_array($options) && !$options instanceof Traversable) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Parameter provided to %s must be an array or Traversable',
                __METHOD__
            ));
        }

        foreach ($options as $key => $value) {
        	$key = strtolower($key);
            if(!isset($this->listeners[$key])) {
            	$this->listeners[$key] = array();
            }
            $this->listeners[$key] = array_merge($this->listeners[$key], $value);
        }
    }
    
    /**
     * Get listener name by module name
     * @param string $moduleName
     */
    public function getListeners()
    {    	 
    	 $this->listeners;
    }
    
    /**
     * Get listener name by module name
     * @param string $moduleName
     */
    public function getListener($moduleName)
    {
    	 $moduleName = strtolower($moduleName);
    	 if(!isset($this->listeners[$moduleName])) {
    	 	return array();
    	 }
    	 
    	 return $this->listeners[$moduleName];
    }
 
    /**
     * Get config listener name by module name
     * @param mixed
     */
    public function getListenerConfig($moduleName, $listener)
    {
    	 $moduleName = strtolower($moduleName);
    	 if(!isset($this->listeners[$moduleName])) {
    	 	return array();
    	 }
    	 if(!isset($this->listeners[$moduleName][$listener])) {
    	 	return array();
    	 }
    	 return $this->listeners[$moduleName][$listener];
    }
    
    /**
     * Has a listener for a module name
     * @param string $moduleName
     * @param string $listener
     */
    public function hasListener($moduleName, $listener)
    {
    	$moduleName = strtolower($moduleName);
    	if(!isset($this->listeners[$moduleName])) {
    	 	return false;
    	}
    	
    	return array_key_exists($listener, $this->listeners[$moduleName]);
    }
}