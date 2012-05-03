<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener;

interface AuthorizeHandler
{
    /**
     * @param string $module
     * @return boolean 
     */
    public function authorizeModule($module);
}