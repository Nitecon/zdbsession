<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace zDbSession;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use zDbSession\Session\SaveHandler\DoctrineGateway;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $settings = $e->getApplication()->getServiceManager()->get("Config");
        if ($settings['zDbSession']['enabled']) {
            $sessionConfig = new \Zend\Session\Config\SessionConfig();
            $sessionConfig->setOptions($settings['zDbSession']['sessionConfig']);
            $saveHandler = new DoctrineGateway($e->getApplication()->getServiceManager());
            $sessionManager = new SessionManager();
            $sessionManager->setConfig($sessionConfig);
            $sessionManager->setSaveHandler($saveHandler);
            Container::setDefaultManager($sessionManager);
            $sessionManager->start();
        }
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }

}
