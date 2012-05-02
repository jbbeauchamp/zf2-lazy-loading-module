ZF2 Lazy loading module
==============

Version 1.2 Created by [Vincent Blanchon](http://developpeur-zend-framework.fr/)

Introduction
------------

For this project, i redefined a party of the module manager to have a lazy loading and increase the performance.
Project exemple is available on [the loazy loading module website](http://lazy-loading.zend-framework-2.fr/)

Lazy Loading module usage
------------

Lazy loading module concept can load only authorize module for the current environment.
Exemple :

1) I want load my "Administration" module only on port 443, and if my client ip is valid.
Without that, to load this module is useless.

The config to load module only on port 443 and ip on white list, with config/application.config.php :

    <?php 
    return array(
        'modules' => array(
            'Application',
            'Cron',
            'Administration'
        ),
        'module_listener_options' => array( 
            'config_cache_enabled' => false,
            'cache_dir'            => 'data/cache',
            'module_paths' => array(
                'Application' => './module/Application',
                'Cron' => './module/Cron',
                'Administration' => './module/Administration',
            ),
            'lazy_loading' => array(
                'Administration' => array(
                    'port' => '443',
                    'remote_addr' => array('127.0.0.1'),
                ),
            ),
        ),
    );
    ?>

2) I want load my "Cron" module only in "cli" sapi and run url in argument :

    <?php 
    return array(
        'modules' => array(
            'Application',
            'Cron',
            'Administration'
        ),
        'module_listener_options' => array( 
            'config_cache_enabled' => false,
            'cache_dir'            => 'data/cache',
            'module_paths' => array(
                'Application' => './module/Application',
                'Cron' => './module/Cron',
                'Administration' => './module/Administration',
            ),
            'lazy_loading' => array(
                'Cron' => array(
                    'getopt' => array('cron=s' => 'cron url'),
                    'sapi' => 'cli',
                ),
            ),
        ),
    );
    ?>

Filter available are : argument in command line, sapi, domain, https protocol, server port, url and remote address.

The cache key will be automatically update with the module loaded.
Just update index with ZFMLL library to use lazy loading :

    <?php

    chdir(dirname(__DIR__));
    require_once (getenv('ZF2_PATH') ?: 'vendor/ZendFramework/library') . '/Zend/Loader/AutoloaderFactory.php';

    Zend\Loader\AutoloaderFactory::factory();
    Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\ClassMapAutoloader'=>array(include 'config/autoload_classmap.php')));

    $appConfig = include 'config/application.config.php';

    $listenerOptions  = new ZFMLL\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
    $defaultListeners = new ZFMLL\Module\Listener\EnvironmentListenerAggregate($listenerOptions);

    $moduleManager = new ZFMLL\Module\Manager($appConfig['modules']);
    $moduleManager->events()->attachAggregate($defaultListeners);
    $moduleManager->loadModules();

    $bootstrap   = new Zend\Mvc\Bootstrap($defaultListeners->getConfigListener()->getMergedConfig());
    $application = new ZFMLL\Mvc\Application();
    $bootstrap->bootstrap($application);
    $application->run()->send();

Benchmark
------------

Benchmark condition :
- no module cache enable
- 100 modules loading, for each test
- homepage action
- lastest master branch version (at the May 1st)

In the first case :

- 4 modules : Application, Administration, Cron and Blog
- In each other Application module, a simple class (like in the project code) :

    class Module implements AutoloaderProvider
    {
        public function init(Manager $moduleManager)
        {
        }

        public function getAutoloaderConfig()
        {
            return array(
                'Zend\Loader\ClassMapAutoloader' => array(
                    __DIR__ . '/autoload_classmap.php',
                ),
            );
        }

        public function getConfig()
        {
            return include __DIR__ . '/config/module.config.php';
        }
    }

=> ZFMLL performance increases up to 5%.

In the seconde case :

- 4 modules : Application, Administration, Cron and Blog
- Cron & Blog have minimal class Module and Administration attach three listeners (listeners function are empty) :

    $events = StaticEventManager::getInstance();
    $events->attach('bootstrap', MvcEvent::EVENT_BOOTSTRAP, array($this, 'initializeAcl'), 100);
    $events->attach('bootstrap', MvcEvent::EVENT_BOOTSTRAP, array($this, 'initializeView'), 100);
    $events->attach('Zend\Module\Manager', 'loadModules.post', array($this, 'initializeNavigation'), -100);

=> ZFMLL performance increases up to 65%.

In the third case :

- 4 modules :Application, Administration, Cron and Blog
- Administration attach the same listeners with the second case, and Blog attach one listener (listener function are empty) :

    $events = StaticEventManager::getInstance();
    $events->attach('bootstrap', MvcEvent::EVENT_BOOTSTRAP, array($this, 'initializeView'), 100);

=> ZFMLL performance increases up to 75%.

With a real code in the several listeners, ZFMLL can increase more of 100% performance !