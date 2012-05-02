<?php

/*
 * This file is part of the ZFMLL package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace ZFMLL\Module\Listener;

use Zend\Loader\PluginClassLoader;

class ListenerLoader extends PluginClassLoader
{
    /**
     * @var array Pre-aliased auth listeners
     */
    protected $plugins = array(
        'sapi'              => 'ZFMLL\Module\Listener\Environment\SapiListener',
       	'getopt'            => 'ZFMLL\Module\Listener\Environment\GetoptListener',
        'domain'            => 'ZFMLL\Module\Listener\Server\DomainListener',
    	'hostname'          => 'ZFMLL\Module\Listener\Server\DomainListener',
        'https'             => 'ZFMLL\Module\Listener\Server\HttpsListener',
        'port'              => 'ZFMLL\Module\Listener\Server\PortListener',
    	'ip'                => 'ZFMLL\Module\Listener\Server\RemoteAddrListener',
    	'remoteaddr'        => 'ZFMLL\Module\Listener\Server\RemoteAddrListener',
        'remote_addr'       => 'ZFMLL\Module\Listener\Server\RemoteAddrListener',
        'uri'               => 'ZFMLL\Module\Listener\Server\UrlListener',
        'url'               => 'ZFMLL\Module\Listener\Server\UrlListener',
    );
}
