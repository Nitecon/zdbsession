<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'zdbsession_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/zDbSession/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'zDbSession\Entity' => 'zdbsession_entities'
                )
            )
        )
    ),
    'service_manager' => array(
        'factories' => array(
            
        )
    ),
);