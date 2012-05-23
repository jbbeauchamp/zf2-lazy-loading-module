<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\ModuleManager\Listener;

interface EnvironmentHandler
{
    /**
     * Get argument environment
     * @param string $params
     * @return mixed 
     */
    public function getArgument($param);
}