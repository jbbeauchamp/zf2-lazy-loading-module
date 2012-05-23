<?php

use Zend\Loader\AutoloaderFactory,
    Zend\ServiceManager\ServiceManager,
    Zend\Mvc\Service\ServiceManagerConfiguration;

chdir(dirname(__DIR__));
require_once (getenv('ZF2_PATH') ?: 'vendor/ZendFramework/library') . '/Zend/Loader/AutoloaderFactory.php';

// Setup autoloader
AutoloaderFactory::factory();
AutoloaderFactory::factory(array('Zend\Loader\ClassMapAutoloader' => array(include 'config/autoload_classmap.php')));

echo "\n";

$nb = 0;
$err = 0;
for($i = 0; $i < 1000; $i++) {

    $time = microtime();

    // Get application stack configuration
    $configuration = include 'config/application.config.standard.php';

    // Setup service manager
    $serviceManager = new ServiceManager(new ServiceManagerConfiguration($configuration['service_manager']));
    $serviceManager->setService('ApplicationConfiguration', $configuration);
    $serviceManager->get('ModuleManager')->loadModules();

    $tmp = (microtime() - $time);
    $nb += ($tmp > 0) ? $tmp : $time;
    if($tmp < 0 ) {
        $err++;
    }
}

echo "average without lazy loading : " . $nb/(1000-$err) . "\n";
echo "\n";
