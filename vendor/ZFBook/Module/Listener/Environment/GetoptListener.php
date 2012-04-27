<?php

namespace ZFBook\Module\Listener\Environment;

use ZFBook\Module\Listener\AbstractListener,
    ZFBook\Module\ModuleEvent,
    Zend\Console\Getopt;

class GetoptListener extends AbstractListener
{
    /**
     * @var Getopt 
     */
    protected $getopt;
    
    /**
     * Lister name
     * @var string
     */
    protected $name = 'getopt';
    
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
    	if(strtolower(ini_get('register_argc_argv'))!='on' && ini_get('register_argc_argv')!='1')
    	{
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
    public function environment(ModuleEvent $e)
    {
    	if(strtolower(ini_get('register_argc_argv'))!='on' && ini_get('register_argc_argv')!='1')
    	{
            return null;
    	}
    	
    	$parameter = $e->getParameterEnvironnement();
        return $this->getGetopt()->getOption($parameter);
    }
}
