<?php

namespace ZFBook\Module\Listener;

use ZFBook\Module\ModuleEvent;

interface EnvironmentHandler
{
    /**
     * 
     * @param ModuleEvent $e
     * @return boolean 
     */
    public function environment(ModuleEvent $e);
}
