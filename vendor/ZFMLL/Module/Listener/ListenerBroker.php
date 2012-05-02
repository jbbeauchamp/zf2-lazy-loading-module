<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener;

use Zend\Loader\PluginBroker,
	ZFMLL\Module\Listener\Exception\InvalidHelperException;

class ListenerBroker extends PluginBroker
{
    /**
     * @var string Default plugin loading strategy
     */
    protected $defaultClassLoader = 'ZFMLL\Module\Listener\ListenerLoader';
	
    /**
     * Load and return a plugin instance
     * 
     * @param  string $plugin 
     * @param  array $options Options to pass to the plugin constructor
     * @return object
     * @throws Exception if plugin not found
     */
    public function load($plugin, array $options = null)
    {
    	// force to use short name
    	$pluginClass = $this->getClassLoader()->getClassName($plugin);
    	if($pluginClass) {
    		return new $pluginClass();
    	}
    	return parent::load($plugin, $options);
    }
    
    /**
     * Determine if we have a valid helper
     * 
     * @param  mixed $plugin 
     * @return true
     * @throws Exception\InvalidHelperException
     */
    protected function validatePlugin($plugin)
    {
    	if (!$plugin instanceof AuthorizeHandler) {
            throw new InvalidHelperException('Auth listeners must implement ZFMLL\Module\Listener\AuthorizeHandler');
        }
    	return true;
    }
}
