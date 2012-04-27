<?php

namespace ZFMLL\Module\Listener;

use ZFMLL\Module\ModuleEvent;

interface EnvironmentHandler
{
    /**
     * 
     * @param ModuleEvent $e
     * @return boolean 
     */
    public function environment(ModuleEvent $e);
}
