<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'doctrine.cache.fscache' => function(\Zend\ServiceManager\ServiceManager $sm) {
                $cache = new \Doctrine\Common\Cache\FilesystemCache('data/cache');
                return $cache;
            }
        )
    ),
    'doctrine' => array(
        'driver' => array(
            'zdbsession_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'fscache',
                'paths' => array(__DIR__ . '/../src/zDbSession/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'zDbSession\Entity' => 'zdbsession_entities'
                )
            )
        )
    ),
    'zDbSession' => array(
        /*
         * Please note that before you enable the zDbSession make sure to import the schema first
         * into your database or it will cause your application to die with a fatal error.
         * For more information about this please consult the readme file.
         */
        'enabled' => \TRUE,
        /* Below is the standard configuration as per Zend Session Config, consult
         * the ZF2 documentation (haha) or just post on stack overflow on the settings details.
         */
        'sessionConfig' => array(
            'cache_expire' => 86400,
            //'cookie_domain' => 'mydomain.com',
            //'name' => 'mydomain',
            'cookie_lifetime' => 1800,
            'gc_maxlifetime' => 1800,
            'cookie_path' => '/',
            'cookie_secure' => TRUE,
            'remember_me_seconds' => 3600,
            'use_cookies' => TRUE,
        )
    ),
);