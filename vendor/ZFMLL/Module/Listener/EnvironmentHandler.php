<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener;

use ZFMLL\Module\ModuleEvent;

interface EnvironmentHandler
{
    /**
     * Get param environment
     * @param string $params
     * @return mixed 
     */
    public function environment($param);
}