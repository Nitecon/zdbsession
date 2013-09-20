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

namespace zDbSession\Session\SaveHandler;

use Zend\Session\SaveHandler\SaveHandlerInterface;
use Doctrine\ORM\EntityManager;

class DoctrineGateway implements SaveHandlerInterface {

    /**
     * Session Save Path
     *
     * @var string
     */
    protected $sessionSavePath;

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
    protected $em;

    /**
     * 
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceManager
     */
    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $serviceManager) {
        $this->sm = $serviceManager;
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
        $rows = $this->getEntityManager()->find('zDbSession\Entity\Session', $id);
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
        $repo = $this->getEntityManager()->getRepository('zDbSession\Entity\Session');
        if (!$entity = $repo->findOneBy(array('id' => $id)))
            $entity = new \zDbSession\Entity\Session();
        $entity->setModified(time());
        $entity->setData((string) $data);
        $entity->setId($id);
        $entity->setName($this->sessionName);
        $entity->setLifetime($this->lifetime);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return \TRUE;
    }

    /**
     * Destroy session
     *
     * @param  string $id
     * @return bool
     */
    public function destroy($id) {
        $entity = $this->getEntityManager()->find('zDbSession\Entity\Session', $id);
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        return \TRUE;
    }

    /**
     * Garbage Collection
     *
     * @param int $maxlifetime
     * @return true
     */
    public function gc($maxlifetime) {
        $repo = $this->getEntityManager()->getRepository("zDbSession\Entity\Session");
        $collection = $repo->findAll();
        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->andWhere($criteria->expr()->lt('modified', time() + $this->lifetime));
        $this->getEntityManager()->remove($collection->matching($criteria));
        $this->getEntityManager()->flush();
        return \TRUE;
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
