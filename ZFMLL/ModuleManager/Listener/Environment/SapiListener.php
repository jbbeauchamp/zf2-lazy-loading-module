<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\ModuleManager\Listener\Environment;

use ZFMLL\ModuleManager\Listener\AbstractListener;
use ZFMLL\ModuleManager\Listener\EnvironmentHandler;

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
}
