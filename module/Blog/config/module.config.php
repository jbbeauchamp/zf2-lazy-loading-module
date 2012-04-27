<?php
return array(
	'di' => array(
        'instance' => array(
            'Blog\Controller\BlogController' => array(
                'parameters' => array(
                ),
             ),
             'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                      	'blog/blog' => __DIR__ . '/../view/blog/blog.phtml',
            		),
                ),
            ),
     	),
    ),
);