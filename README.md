ZF2 Lazy loading module
==============

Version 1.5 Created by [Vincent Blanchon](http://developpeur-zend-framework.fr/)

Introduction
------------

For this project, i redefined a party of the module manager to have a lazy loading and increase the performance.
Project exemple is available on [the loazy loading module website](http://lazy-loading.zend-framework-2.fr/)

Installation
------------

1) Modify your ./init_autoloader.php :
```php
<?php

require_once __DIR__ . '/vendor/ZF2/library/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true,
    ),
    'Zend\Loader\ClassMapAutoloader' => array(
        __DIR__ . '/config/autoload_classmap.php'
    ),
));
```

2) Create a file ./config/autoload_classmap.php :
```php
<?php
return array(
    'ZFMLL\Mvc\Service\ModuleManagerFactory' => __DIR__ . '/../vendor/ZFMLL/Mvc/Service/ModuleManagerFactory.php',
    'ZFMLL\ModuleManager\ModuleManager' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/ModuleManager.php',
    'ZFMLL\ModuleManager\Exception' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Exception.php',
    'ZFMLL\ModuleManager\ModuleEvent' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/ModuleEvent.php',
    'ZFMLL\ModuleManager\Listener\Exception\InvalidListenerException' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Exception/InvalidListenerException.php',
    'ZFMLL\ModuleManager\Listener\Exception\InvalidArgumentException' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Exception/InvalidArgumentException.php',
    'ZFMLL\ModuleManager\Listener\Config\LazyLoading' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Config/LazyLoading.php',
    'ZFMLL\ModuleManager\Listener\ConfigListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/ConfigListener.php',
    'ZFMLL\ModuleManager\Listener\AuthManager' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/AuthManager.php',
    'ZFMLL\ModuleManager\Listener\ListenerManager' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/ListenerManager.php',
    'ZFMLL\ModuleManager\Listener\ListenerOptions' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/ListenerOptions.php',
    'ZFMLL\ModuleManager\Listener\AuthorizeHandlerInterface' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/AuthorizeHandlerInterface.php',
    'ZFMLL\ModuleManager\Listener\AbstractListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/AbstractListener.php',
    'ZFMLL\ModuleManager\Listener\AuthListenerAggregate' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/AuthListenerAggregate.php',
    'ZFMLL\ModuleManager\Listener\Environment\GetoptListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Environment/GetoptListener.php',
    'ZFMLL\ModuleManager\Listener\Environment\SapiListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Environment/SapiListener.php',
    'ZFMLL\ModuleManager\Listener\Server\HttpsListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Server/HttpsListener.php',
    'ZFMLL\ModuleManager\Listener\Server\RemoteAddrListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Server/RemoteAddrListener.php',
    'ZFMLL\ModuleManager\Listener\Server\PortListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Server/PortListener.php',
    'ZFMLL\ModuleManager\Listener\Server\DomainListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Server/DomainListener.php',
    'ZFMLL\ModuleManager\Listener\Server\UrlListener' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Server/UrlListener.php',
    'ZFMLL\ModuleManager\Listener\Server\DateTime' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Server/DateTime.php',
    'ZFMLL\ModuleManager\Listener\Server\HttpMethod' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Server/HttpMethod.php',
    'ZFMLL\ModuleManager\Listener\Server\UserAgent' => __DIR__ . '/../vendor/ZFMLL/ModuleManager/Listener/Server/UserAgent.php',
);
```

3) Modify your ./config/application.config.php :
```php
<?php
return array(
    'modules' => array(
        'Application',
    	'Test',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
		'lazy_loading' => array(
            'Test' => array(
                'url' => array('regex' => '/test/.*' ),
            ),
        ),
    ),
	'service_manager' => array(
        'factories'    => array(
            'ModuleManager' => 'ZFMLL\Mvc\Service\ModuleManagerFactory',
        ),
    ),
);
```

Lazy Loading module usage
------------

Lazy loading module concept can load only authorize module for the current environment.
Exemple :

1) I want load my "Administration" module only on port 443, and if my client ip is valid.
Without that, to load this module is useless.

The config to load module only on port 443 and ip on white list, with config/application.config.php :

```php
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
            'Administration' => array(
                'port' => '443',
                'remote_addr' => array('127.0.0.1'),
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
?>
```

2) I want load my "Cron" module only in "cli" sapi and run url in argument :

```php
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
?>
```

Filter available are : argument in command line, sapi, domain, https protocol, server port, url and remote address.

The cache key will be automatically update with the module loaded.

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

```php
<?php

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
```

=> ZFMLL performance increases **up to 5%**.

In the seconde case :

- 4 modules : Application, Administration, Cron and Blog
- Cron & Blog have minimal class Module and Administration attach three listeners (listeners function are empty) :

```php
<?php

$events = $manager->events()->getSharedManager();
$events->attach('application', MvcEvent::EVENT_BOOTSTRAP, array($this, 'firstListener'), 100);
$events->attach('application', MvcEvent::EVENT_BOOTSTRAP, array($this, 'secondListener'), 100);
$events->attach('Zend\ModuleManager\ModuleManager', 'loadModules.post', array($this, 'thirdListener'), -100);
```

=> ZFMLL performance increases **up to 55%**.

In the third case :

- 4 modules :Application, Administration, Cron and Blog
- Administration attach the same listeners with the second case, and Blog attach two listeners (listener function are empty) :

```php
<?php

$events = $manager->events()->getSharedManager();
$events->attach('application', MvcEvent::EVENT_BOOTSTRAP, array($this, 'firstListener'), 100);
$events->attach('application', MvcEvent::EVENT_BOOTSTRAP, array($this, 'secondListener'), 100);
```

=> ZFMLL performance increases **up to 60%**.

With a real code in the several listeners, ZFMLL can increase more of 75% performance !
