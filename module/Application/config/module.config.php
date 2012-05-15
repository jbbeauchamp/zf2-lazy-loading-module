<?php
return array(
    'di' => array(
        'instance' => array(
            'Application\Controller\IndexController' => array(
                'parameters' => array(
                ),
             ),
             'Application\Controller\AppController' => array(
                'parameters' => array(
                ),
             ),
            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker'       => 'Zend\Mvc\Controller\PluginBroker',
                ),
            ),
            'Zend\Mvc\Controller\PluginBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\Mvc\Controller\PluginLoader',
                ),
            ),
            'Zend\Mvc\Router\RouteStackInterface' => array(
                'parameters' => array(
                    'routes' => array(
                        'home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/',
                                'defaults' => array(
                                    'controller' => 'Application\Controller\IndexController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'app' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/application',
                                'defaults' => array(
                                    'controller' => 'Application\Controller\AppController',
                                    'action'     => 'app',
                                ),
                            ),
                        ),
                        'admin-load' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/admin',
                                'defaults' => array(
                                    'controller' => 'Application\Controller\AppController',
                                    'action'     => 'adminload',
                                ),
                            ),
                        ),
                        'cron-load' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/cron',
                                'defaults' => array(
                                    'controller' => 'Application\Controller\AppController',
                                    'action'     => 'cronload',
                                ),
                            ),
                        ),
                        'admin-home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/admin-443',
                                'defaults' => array(
                                    'controller' => 'Administration\Controller\AdminController',
                                    'action'     => 'admin',
                                ),
                            ),
                        ),
                        'blog-home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/blog/my-article',
                                'defaults' => array(
                                    'controller' => 'Blog\Controller\BlogController',
                                    'action'     => 'blog',
                                ),
                            ),
                        ),
                        'cron-home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/cron-cli',
                                'defaults' => array(
                                    'controller' => 'Cron\Controller\CronController',
                                    'action'     => 'cron',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'Zend\View\Renderer\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\TemplateMapResolver',
                ),
            ),
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                        'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
                        'index/index' => __DIR__ . '/../view/index/index.phtml',
                        'app/app' => __DIR__ . '/../view/app/app.phtml',
            			'app/adminload' => __DIR__ . '/../view/app/adminload.phtml',
            			'app/cronload' => __DIR__ . '/../view/app/cronload.phtml',
            			'error/404' => __DIR__ . '/../view/error/404.phtml',
            			'error/error' => __DIR__ . '/../view/error/exception.phtml',
            			'app/not-found' => __DIR__ . '/../view/error/404.phtml',
                    ),
                ),
            ),
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'layoutTemplate' => 'layout/layout',
                ),
            ),
            'Zend\View\Helper\Url' => array(
                'parameters' => array(
                    'router' => 'Zend\Mvc\Router\RouteStackInterface',
                ),
            ),
            'Zend\View\Helper\Doctype' => array(
                'parameters' => array(
                    'doctype' => 'HTML5',
                ),
            ),
            'Zend\Mvc\View\RouteNotFoundStrategy' => array(
                'parameters' => array(
                    'displayNotFoundReason' => true,
                    'displayExceptions'     => true,
                    'notFoundTemplate'      => 'error/404',
                ),
            ),
            'Zend\Mvc\View\ExceptionStrategy' => array(
                'parameters' => array(
                    'displayExceptions' => true,
                    'exceptionTemplate' => 'error/exception',
                ),
            ),
        ),
    ),
);
