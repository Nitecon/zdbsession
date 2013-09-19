<?php

/**
 * This file is part of the DoctrineGateway
 * 
 * Copyright (c) 2013 Will Hattingh
 * 
 * For the full copyright and license information, please view
 * the file LICENSE.txt that was distributed with this source code.
 * 
 * Description of DoctrineGateway
 * @author whatting
 */

namespace zDbSession\SaveHandler;

use Zend\Session\SaveHandler\SaveHandlerInterface;
use Doctrine\ORM\EntityManager;

class DoctrineGateway implements SaveHandlerInterface {

    /**
     * Session Save Path
     *
     * @var string
     */
    protected $sessionSavePath;

    protected $entityName = 'zDbSession\Entity\Session';
    /**
     * Session Name
     *
     * @var string
     */
    protected $sessionName;

    /**
     * Lifetime
     * @var int
     */
    protected $lifetime;

    /** @var \Zend\ServiceManager\ServiceLocatorInterface */
    protected $sm;
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $serviceManager) {
        $this->sm = $serviceManager;
        $this->em = $this->getEntityManager();
    }

    /**
     * Open Session
     *
     * @param  string $savePath
     * @param  string $name
     * @return bool
     */
    public function open($savePath, $name) {
        $this->sessionSavePath = $savePath;
        $this->sessionName = $name;
        $this->lifetime = ini_get('session.gc_maxlifetime');

        return true;
    }

    /**
     * Close session
     *
     * @return bool
     */
    public function close() {
        return true;
    }

    /**
     * Read session data
     *
     * @param string $id
     * @return string
     */
    public function read($id) {
        $repository = $this->getEntityManager()->getRepository($this->entityName);
        $rows = $repository->findBy(array("id" => $id));
        if (count($rows) > 0) {
            if ($rows->getModified() + $rows->getLifetime() > time()) {
                return $rows->getData();
            }
            $this->destroy($id);
        }
        return '';
    }

    /**
     * Write session data
     *
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write($id, $data) {
        $entity = new \zDbSession\Entity\Session();
        $entity->setModified(time());
        $entity->setData((string) $data);
        $entity->setId($id);
        $entity->setName($this->sessionName);
        $entity->setLifetime($this->lifetime);
        $this->em->persist($entity);
        $this->em->flush();
        return \TRUE;
    }

    /**
     * Destroy session
     *
     * @param  string $id
     * @return bool
     */
    public function destroy($id) {
        return (bool) $this->tableGateway->delete(array(
                    $this->options->getIdColumn() => $id,
                    $this->options->getNameColumn() => $this->sessionName,
        ));
    }

    /**
     * Garbage Collection
     *
     * @param int $maxlifetime
     * @return true
     */
    public function gc($maxlifetime) {
        $platform = $this->tableGateway->getAdapter()->getPlatform();
        return (bool) $this->tableGateway->delete(sprintf('%s + %s < %d', $platform->quoteIdentifier($this->options->getModifiedColumn()), $platform->quoteIdentifier($this->options->getLifetimeColumn()), time()
        ));
    }

    /**
     * Sets the EntityManager
     *
     * @param EntityManager $em
     * @access protected
     * @return PostController
     */
    protected function setEntityManager(EntityManager $em) {
        $this->em = $em;
        return $this;
    }

    /**
     * Returns the EntityManager
     *
     * Fetches the EntityManager from ServiceLocator if it has not been initiated
     * and then returns it
     *
     * @access protected
     * @return EntityManager
     */
    protected function getEntityManager() {
        if (null === $this->em) {
            $this->setEntityManager($this->sm->get('Doctrine\ORM\EntityManager'));
        }
        return $this->em;
    }

}
