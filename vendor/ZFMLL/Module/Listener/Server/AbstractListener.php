<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener\Server;

use ZFMLL\Module\Listener\AbstractListener as BaseListener,
    ZFMLL\Module\ModuleEvent;

class AbstractListener extends BaseListener
{
    /**
     *
     * @param ModuleEvent $e
     * @return string 
     */
    public function environment($param)
    {
        return $_SERVER[$param];
    }
}
