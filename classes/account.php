<?php

class Account{

    private $_username;
    private $_password;
    private $_firstname;
    private $_lastname;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->_firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->_lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
    }
}