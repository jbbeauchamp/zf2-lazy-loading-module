<?php

namespace ZFMLLTest\Module;

use PHPUnit_Framework_TestCase as TestCase,
    Zend\Loader\ModuleAutoloader,
    Zend\Loader\AutoloaderFactory,
    ZFMLL\Module\Manager,
    ZFMLL\Module\Listener\ListenerOptions,
    Zend\EventManager\EventManager,
    ZFMLL\Module\Listener\EnvironmentListenerAggregate,
    InvalidArgumentException;

class ManagerTest extends TestCase
{
    public function setUp()
    {
        $this->tmpdir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'zend_module_cache_dir';
        @mkdir($this->tmpdir);
        $this->configCache = $this->tmpdir . DIRECTORY_SEPARATOR . 'config.cache.php';
        // Store original autoloaders
        $this->loaders = spl_autoload_functions();
        if (!is_array($this->loaders)) {
            // spl_autoload_functions does not return empty array when no
            // autoloaders registered...
            $this->loaders = array();
        }

        // Store original include_path
        $this->includePath = get_include_path();

        $this->defaultListeners = new EnvironmentListenerAggregate(
            new ListenerOptions(array( 
                'module_paths'         => array(
                    realpath(__DIR__ . '/TestAsset'),
                ),
            ))
        );
    }

    public function tearDown()
    {
        $file = glob($this->tmpdir . DIRECTORY_SEPARATOR . '*');
        @unlink($file[0]); // change this if there's ever > 1 file 
        @rmdir($this->tmpdir);
        // Restore original autoloaders
        AutoloaderFactory::unregisterAutoloaders();
        $loaders = spl_autoload_functions();
        if (is_array($loaders)) {
            foreach ($loaders as $loader) {
                spl_autoload_unregister($loader);
            }
        }

        foreach ($this->loaders as $loader) {
            spl_autoload_register($loader);
        }

        // Restore original include_path
        set_include_path($this->includePath);
    }

    public function testCanLoadSomeModule()
    {
        $configListener = $this->defaultListeners->getConfigListener();
        $moduleManager  = new Manager(array('SomeModule'), new EventManager);
        $moduleManager->events()->attachAggregate($this->defaultListeners);
        $moduleManager->loadModules();
        $loadedModules = $moduleManager->getLoadedModules();
        $this->assertInstanceOf('SomeModule\Module', $loadedModules['SomeModule']);
        $config = $configListener->getMergedConfig();
        $this->assertSame($config->some, 'thing');
    }
    
    public function testCanLoadSomeModuleWithLazyLoading()
    {
        $configListener = $this->defaultListeners->getOptions()->setLazyLoading(array('SomeModule'=>array('sapi'=>php_sapi_name())));
        $configListener = $this->defaultListeners->getConfigListener();
        $moduleManager  = new Manager(array('SomeModule'), new EventManager);
        $moduleManager->events()->attachAggregate($this->defaultListeners);
        $moduleManager->loadModules();
        $loadedModules = $moduleManager->getLoadedModules();
        $this->assertInstanceOf('SomeModule\Module', $loadedModules['SomeModule']);
        $config = $configListener->getMergedConfig();
        $this->assertSame($config->some, 'thing');
    }
    
    public function testCanLoadSomeModuleWithLazyLoadingRestricted()
    {
        $configListener = $this->defaultListeners->getOptions()->setLazyLoading(array('SomeModule'=>array('sapi'=>'fail')));
        $configListener = $this->defaultListeners->getConfigListener();
        $moduleManager  = new Manager(array('SomeModule'), new EventManager);
        $moduleManager->events()->attachAggregate($this->defaultListeners);
        $moduleManager->loadModules();
        $loadedModules = $moduleManager->getLoadedModules();
        $this->assertEquals(0, count($loadedModules));
    }
    
    public function testCanLoadMultipleModules()
    {
        $configListener = $this->defaultListeners->getConfigListener();
        $moduleManager  = new Manager(array('BarModule', 'BazModule'));
        $moduleManager->events()->attachAggregate($this->defaultListeners);
        $moduleManager->loadModules();
        $loadedModules = $moduleManager->getLoadedModules();
        $this->assertInstanceOf('BarModule\Module', $loadedModules['BarModule']);
        $this->assertInstanceOf('BazModule\Module', $loadedModules['BazModule']);
        $this->assertInstanceOf('BarModule\Module', $moduleManager->getModule('BarModule'));
        $this->assertInstanceOf('BazModule\Module', $moduleManager->getModule('BazModule'));
        $this->assertNull($moduleManager->getModule('NotLoaded'));
        $config = $configListener->getMergedConfig();
        $this->assertSame('foo', $config->bar);
        $this->assertSame('bar', $config->baz);
    }
    
    public function testCanLoadMultipleModulesWithLazyLoading()
    {
        $configListener = $this->defaultListeners->getOptions()->setLazyLoading(array('BarModule'=>array('sapi' => php_sapi_name())));
        $configListener = $this->defaultListeners->getOptions()->setLazyLoading(array('BazModule'=>array('sapi' => php_sapi_name())));
        $configListener = $this->defaultListeners->getConfigListener();
        $moduleManager  = new Manager(array('BarModule', 'BazModule'));
        $moduleManager->events()->attachAggregate($this->defaultListeners);
        $moduleManager->loadModules();
        $loadedModules = $moduleManager->getLoadedModules();
        $this->assertInstanceOf('BarModule\Module', $loadedModules['BarModule']);
        $this->assertInstanceOf('BazModule\Module', $loadedModules['BazModule']);
        $this->assertInstanceOf('BarModule\Module', $moduleManager->getModule('BarModule'));
        $this->assertInstanceOf('BazModule\Module', $moduleManager->getModule('BazModule'));
        $this->assertNull($moduleManager->getModule('NotLoaded'));
        $config = $configListener->getMergedConfig();
        $this->assertSame('foo', $config->bar);
        $this->assertSame('bar', $config->baz);
    }
    
    
    public function testCanLoadMultipleModulesWithLazyLoadingRestricted()
    {
        $configListener = $this->defaultListeners->getOptions()->setLazyLoading(array('BarModule'=>array('sapi' => php_sapi_name())));
        $configListener = $this->defaultListeners->getOptions()->setLazyLoading(array('BazModule'=>array('sapi' => 'fail')));
        $configListener = $this->defaultListeners->getConfigListener();
        $moduleManager  = new Manager(array('BarModule', 'BazModule'));
        $moduleManager->events()->attachAggregate($this->defaultListeners);
        $moduleManager->loadModules();
        $loadedModules = $moduleManager->getLoadedModules();
        $this->assertEquals(1, count($loadedModules));
        $this->assertInstanceOf('BarModule\Module', array_shift($loadedModules));
    }
    
    public function testCanLoadMultipleModulesWithMultipleLazyLoadingRestrictedSuccess()
    {
        $_SERVER['SERVER_PORT'] = 443;
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['REMOTE_ADDR'] = '12.14.16.15';
        $_SERVER['REQUEST_URI'] = '/blog/my-article';
        $_SERVER['HTTP_HOST'] = 'lazy-loading.zend-framework-2.fr';
        $configListener = $this->defaultListeners->getOptions()->setLazyLoading(array(
            'SomeModule' => array('domain' => 'lazy-loading.zend-framework-2.fr'),
            'BarModule' => array('sapi' => php_sapi_name(), 'port' => 443, 'https' => 'on'),
            'BazModule' => array('remote_addr' => array('12.14.16.15'), 'url' => array('regex' => '/blog/.*')),
        ));
        $configListener = $this->defaultListeners->getConfigListener();
        $moduleManager  = new Manager(array('BarModule', 'BazModule', 'SomeModule'));
        $moduleManager->events()->attachAggregate($this->defaultListeners);
        $moduleManager->loadModules();
        $loadedModules = $moduleManager->getLoadedModules();
        $this->assertEquals(3, count($loadedModules));
    }
    
    public function testCanLoadMultipleModulesWithMultipleLazyLoadingRestrictedFail()
    {
        $_SERVER['SERVER_PORT'] = 443;
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['REMOTE_ADDR'] = '12.14.16.15';
        $_SERVER['REQUEST_URI'] = '/blog/my-article';
        $_SERVER['HTTP_HOST'] = 'lazy-loading.zend-framework-2.fr';
        $configListener = $this->defaultListeners->getOptions()->setLazyLoading(array(
            'SomeModule' => array('domain' => 'zend-framework-2.fr'),
            'BarModule' => array('sapi' => 'cgi', 'port' => 80, 'https' => 'off'),
            'BazModule' => array('remote_addr' => '15.15.15.15', 'url' => array('regex' => 'myblog')),
        ));
        $configListener = $this->defaultListeners->getConfigListener();
        $moduleManager  = new Manager(array('BarModule', 'BazModule', 'SomeModule'));
        $moduleManager->events()->attachAggregate($this->defaultListeners);
        $moduleManager->loadModules();
        $loadedModules = $moduleManager->getLoadedModules();
        $this->assertEquals(0, count($loadedModules));
    }
}