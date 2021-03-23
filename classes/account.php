<?php
/*
 * Desc:    Class Account creates an account object used to store user information during the account
 *          creation process for the SouthGarage App.
 * Date:    3/1/2021
 * File:    account.php
 * Auth:    Ryan Rivera & Husrav Khomidov
 */
class Account{

    private $_email;
    private $_pass;
    private $_firstname;
    private $_lastname;
    private $_role;

    /**
     * This functions gets the account's role
     * @return mixed
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * This function sets the account's role
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->_role = $role;
    }

    /**
     * This function gets the account's email
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * This function sets the account's email
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * This function gets the account's pass
     * @return mixed
     */
    public function getPass()
    {
        return $this->_pass;
    }

    /**
     * This function sets the account's pass
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->_pass = $pass;
    }

    /**
     * This function gets the account's firstname
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->_firstname;
    }

    /**
     * This function sets the account's firstname
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
    }

    /**
     * This function gets the account's lastname
     * @return mixed
     */
    public function getLastname()
    {
        return $this->_lastname;
    }

    /**
     * This function sets the account's lastname
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
    }
}