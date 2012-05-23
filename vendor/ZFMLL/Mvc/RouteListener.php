<?php


/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Mvc;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\RouteListener as BaseRouteListener;


class RouteListener extends BaseRouteListener
{
    /**
     * Listen to the "route" event and attempt to route the request
     *
     * If no matches are returned, triggers "dispatch.error" in order to
     * create a 404 response.
     *
     * Seeds the event with the route match on completion.
     * 
     * @param  MvcEvent $e 
     * @return null|Router\RouteMatch
     */
    public function onRoute($e)
    {
        $manager = $e->getApplication()->getServiceManager()->get('ModuleManager');
        $event = $manager->getEvent();
        $event->setParameterArgument('cron');
        $result = $manager->events()->trigger('loadModuleAuth.argument', $this, $event);
        
        if(($arg = $result->last())) {
            $e->getRequest()->setUri($arg);
        }
        
        $routeMatch = parent::onRoute($e);
        return $routeMatch;
    }
}
