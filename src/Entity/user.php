<?php

namespace Entity;


/**
 * User
 * 
 * @Entity
 * @Table(name="t_users")
 */
class User
{
    /**
     * @Id
     * @Column(type="integer",name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *@Column(name="username", type="string") 
     */
    protected $username;
    
    
    /**
     * 
     *@Column(type="string", name="password")
     */
    protected $password;
    
    public function getId () {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
        public function getUsername () {
        return $this->username;
    }
    
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }
    
        public function getPassword () {
        return $this-> password;
    }
    
    public function setPassword($password) {
        $this->password = sha1($password);
        return $this;
    }

}  

