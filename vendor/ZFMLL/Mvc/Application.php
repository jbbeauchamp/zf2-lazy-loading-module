<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Mvc;

use Zend\Mvc\Application as ZFApplication,
    Zend\Mvc\MvcEvent,
    Zend\Console\Getopt;

class Application extends ZFApplication
{
    /**
     * Route the request
     *
     * @param  MvcEvent $e
     * @return Router\RouteMatch
     */
    public function route(MvcEvent $e)
    {
        $manager = $this->getLocator()->get('ZFMLL\Module\Manager');
        $event = $manager->getEvent();
        $event->setParameterEnvironnement('cron');
        $result = $manager->events()->trigger('routeModule.environment', $this, $event, function($r) {
            return is_string($r) && strlen($r) > 0;
        });
        
        if(($opt = $result->last())) {
            $e->getRequest()->setUri($opt);
        }
        
        $routeMatch = parent::route($e);
        return $routeMatch;
    }
}
