<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\ModuleManager\Listener;

use Zend\Loader\PluginClassLoader;

class ListenerLoader extends PluginClassLoader
{
    /**
     * @var array Pre-aliased auth listeners
     */
    protected $plugins = array(
        'sapi'              => 'ZFMLL\ModuleManager\Listener\Environment\SapiListener',
       	'getopt'            => 'ZFMLL\ModuleManager\Listener\Environment\GetoptListener',
        'domain'            => 'ZFMLL\ModuleManager\Listener\Server\DomainListener',
    	'hostname'          => 'ZFMLL\ModuleManager\Listener\Server\DomainListener',
        'https'             => 'ZFMLL\ModuleManager\Listener\Server\HttpsListener',
        'port'              => 'ZFMLL\ModuleManager\Listener\Server\PortListener',
    	'ip'                => 'ZFMLL\ModuleManager\Listener\Server\RemoteAddrListener',
    	'remoteaddr'        => 'ZFMLL\ModuleManager\Listener\Server\RemoteAddrListener',
        'remote_addr'       => 'ZFMLL\ModuleManager\Listener\Server\RemoteAddrListener',
        'uri'               => 'ZFMLL\ModuleManager\Listener\Server\UrlListener',
        'url'               => 'ZFMLL\ModuleManager\Listener\Server\UrlListener',
    );
}
