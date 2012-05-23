<?php
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'index',
                        'action' => 'index',
                    ),
                ),
            ),
            'app' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        'controller' => 'app',
                        'action' => 'app',
                    ),
                ),
            ),
            'admin-load' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'controller' => 'app',
                        'action' => 'adminload',
                    ),
                ),
            ),
            'cron-load' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/cron',
                    'defaults' => array(
                        'controller' => 'app',
                        'action' => 'cronload',
                    ),
                ),
            ),
            'cron-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/cron-cli',
                    'defaults' => array(
                        'controller' => 'cron',
                        'action' => 'cron',
                    ),
                ),
            ),
            'admin-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin-443',
                    'defaults' => array(
                        'controller' => 'admin',
                        'action' => 'admin',
                    ),
                ),
            ),
            'blog-home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/blog/my-article',
                    'defaults' => array(
                        'controller' => 'blog',
                        'action' => 'blog',
                    ),
                ),
            ),
        ),
    ),
    'controller' => array(
        'classes' => array(
            'index' => 'Application\Controller\IndexController',
            'app' => 'Application\Controller\AppController',
            'blog' => 'Blog\Controller\BlogController',
            'admin' => 'Administration\Controller\AdminController',
            'cron' => 'Cron\Controller\CronController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'application/app/not-found',
        'exception_template'       => 'application/error/error',
        'template_map' => array(
            'application/layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/index/index.phtml',
            'application/app/app' => __DIR__ . '/../view/app/app.phtml',
            'application/app/adminload' => __DIR__ . '/../view/app/adminload.phtml',
            'application/app/cronload' => __DIR__ . '/../view/app/cronload.phtml',
            'application/error/404' => __DIR__ . '/../view/error/404.phtml',
            'application/error/error' => __DIR__ . '/../view/error/index.phtml',
            'application/app/not-found' => __DIR__ . '/../view/error/404.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
