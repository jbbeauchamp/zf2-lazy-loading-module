<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener\Environment;

use ZFMLL\Module\Listener\AbstractListener,
    ZFMLL\Module\ModuleEvent;

class SapiListener extends AbstractListener
{
    /**
     * 
     * @param string $module
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
        return php_sapi_name() === $this->config;
    }
    
    /**
     *
     * @param ModuleEvent $e
     * @return string 
     */
    public function environment($param)
    {
    	if(strtolower(ini_get('register_argc_argv'))!='on' && ini_get('register_argc_argv')!='1')
    	{
            return null;
    	}
    	
    	$argv = $_SERVER['argv'];
    	foreach($argv as $arg) {
            $match = array();
            if(preg_match('#^--'.$param.'=(.*)$#', $arg, $match)) {
                    return $match[1];
            }
    	}
        return null;
    }
}
