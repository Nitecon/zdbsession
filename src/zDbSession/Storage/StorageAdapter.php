<?php

/**
 * This file is part of the StorageAdapter
 * 
 * Copyright (c) 2013 Will Hattingh
 * 
 * For the full copyright and license information, please view
 * the file LICENSE.txt that was distributed with this source code.
 * 
 * Description of StorageAdapter
 * @author whatting
 */
namespace zDbSession\Storage;
use zDbSession\SaveHandler\DoctrineGateway;
use Zend\Session\SessionManager;
use Zend\Session\Container;
class StorageAdapter {
    private $sm;
    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $serviceManager){
        $this->sm = $serviceManager;
    }
    public function setSessionStorage(){
        
        $saveHandler = new DoctrineGateway($this->sm);
        $sessionManager = new SessionManager();
        $sessionManager->setSaveHandler($saveHandler);
        Container::setDefaultManager($sessionManager);
        $sessionManager->start();
    }
}
