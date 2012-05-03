<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener\Environment;

use ZFMLL\Module\Listener\AbstractListener,
    ZFMLL\Module\Listener\EnvironmentHandler,
    Zend\Console\Getopt;

class GetoptListener extends AbstractListener implements EnvironmentHandler
{
    /**
     * @var Getopt 
     */
    protected $getopt;
    
    /**
     * get return of parse
     * @var type 
     */
    protected $isBad = false;

    /**
     *
     * @param string $module
     * @return boolean 
     */
    public function authorizeModule($moduleName)
    {
    	if(strtolower(ini_get('register_argc_argv'))!='on' && ini_get('register_argc_argv')!='1') {
            return false;
    	}
        
        $numOpt = 0;
        foreach($this->config as $config => $comment) {
            if(preg_match('#^[^=]+=#', $config)) {
                $numOpt++;    
            }
        }
        
        return count($this->getGetopt()->getOptions()) == $numOpt;
    }
    
    /**
     * Get argument on command line
     * @return Getopt 
     */
    public function getGetopt()
    {
        if(!$this->getopt) {
            $this->getopt = @new Getopt($this->config);
            $this->getopt->parse();
        }
        return $this->getopt;
    }
    
    /**
     *
     * @param ModuleEvent $e
     * @return string 
     */
    public function getArgument($param)
    {
    	if(strtolower(ini_get('register_argc_argv'))!='on' && ini_get('register_argc_argv')!='1') {
            return null;
    	}
    	
        return $this->getGetopt()->getOption($param);
    }
}
