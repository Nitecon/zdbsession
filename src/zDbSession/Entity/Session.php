<?php

/**
 * This file is part of the Session
 * 
 * Copyright (c) 2013 Will Hattingh
 * 
 * For the full copyright and license information, please view
 * the file LICENSE.txt that was distributed with this source code.
 * 
 * Description of Session
 * @author whatting
 */
namespace zDbSession\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Session {
    /**
    * @ORM\Id
    * @ORM\Column(type="string") 
    */
    protected $id;
    /** @ORM\Column(type="string") */
    protected $name;
    /** @ORM\Column(type="integer") */
    protected $modified;
    /** @ORM\Column(type="integer") */
    protected $lifetime;
    /** @ORM\Column(type="object") */
    protected $data;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getModified() {
        return $this->modified;
    }

    public function getLifetime() {
        return $this->lifetime;
    }

    public function getData() {
        return $this->data;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setModified($modified) {
        $this->modified = $modified;
    }

    public function setLifetime($lifetime) {
        $this->lifetime = $lifetime;
    }

    public function setData($data) {
        $this->data = $data;
    }


}
