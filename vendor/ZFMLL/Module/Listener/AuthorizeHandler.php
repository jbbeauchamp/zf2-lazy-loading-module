<?php

namespace ZFMLL\Module\Listener;

use ZFMLL\Module\ModuleEvent;

interface AuthorizeHandler
{
    /**
     * 
     * @param ModuleEvent $e
     * @return boolean 
     */
    public function authorize(ModuleEvent $e);
    
    /**
     * @param string $module
     * @return boolean 
     */
    public function authorizeModule($module);
}
