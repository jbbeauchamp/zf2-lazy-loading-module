<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Mvc;

use Zend\Mvc\Application as ZFApplication,
    Zend\Mvc\MvcEvent;

class Application extends ZFApplication
{
    /**
     * Route the request
     *
     * @param  MvcEvent $e
     * @return Zend\Mvc\Router\RouteMatch
     */
    public function route(MvcEvent $e)
    {
        $manager = $this->getLocator()->get('ZFMLL\Module\Manager');
        $event = $manager->getEvent();
        $event->setParameterArgument('cron');
        $result = $manager->events()->trigger('loadModuleAuth.argument', $this, $event);
        
        if(($arg = $result->last())) {
            $e->getRequest()->setUri($arg);
        }
        
        $routeMatch = parent::route($e);
        return $routeMatch;
    }
}
