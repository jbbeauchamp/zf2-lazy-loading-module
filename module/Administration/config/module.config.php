<?php
return array(
	'di' => array(
        'instance' => array(
            'Administration\Controller\AdminController' => array(
                'parameters' => array(
                ),
             ),
             'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                    	'administration/admin' => __DIR__ . '/../view/administration/admin.phtml',
            		),
                ),
            ),
     	),
	),
);