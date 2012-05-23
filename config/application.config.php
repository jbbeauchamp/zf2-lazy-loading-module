<?php
return array(
    'modules' => array(
        'Application',
        'Cron',
        'Administration',
        'Blog',
    ),
    'module_listener_options' => array( 
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'config_cache_enabled' => false,
        'cache_dir'            => 'data/cache',
        'module_paths' => array(
            'Application' => './module/Application',
            'Cron' => './module/Cron',
            'Administration' => './module/Administration',
            'Blog' => './module/Blog',
        ),
        'lazy_loading' => array(
            'Cron' => array(
             'getopt' => array('cron=s' => 'cron url'),
             'sapi' => 'cli',
            ),
            'Administration' => array(
             'port' => 443,
             'remote_addr' => array('127.0.0.1'),
            ),
            'Blog' => array(
             //'domain' => 'blog.zend-framework-2.fr',
             'url' => array('regex' => '/blog/.*' ),
            ),
        ),
    ),
    'service_manager' => array(
        'use_defaults' => true,
        'factories'    => array(
            'ModuleManager' => 'ZFMLL\Mvc\Service\ModuleManagerFactory',
        ),
        'services' => array(
            'RouteListener' => 'ZFMLL\Mvc\RouteListener',
        ),
    ),
);
