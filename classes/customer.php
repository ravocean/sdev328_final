<?php
/*
 * Desc:    Class Customer creates an Customer object used to store additional user information during the account
 *          creation process for the SouthGarage App.
 * Date:    3/1/2021
 * File:    customer.php
 * Auth:    Ryan Rivera & Husrav Khomidov
 */
class Customer extends Account{

    private $_address1;
    private $_address2;
    private $_phone;
    private $_city;
    private $_state;
    private $_zip;

    /**
     * This function gets the customer's address 1
     * @return mixed customer's address 1
     */
    public function getAddress1()
    {
        return $this->_address1;
    }

    /**
     * This function sets the customer's address 1
     * @param mixed $address1 customer's address 1
     */
    public function setAddress1($address1)
    {
        $this->_address1 = $address1;
    }

    /**
     * This function gets the customer's address 2
     * @return mixed customer's address 2
     */
    public function getAddress2()
    {
        return $this->_address2;
    }

    /**
     * This function sets the customer's address 2
     * @param mixed $address2 customer's address 2
     */
    public function setAddress2($address2)
    {
        $this->_address2 = $address2;
    }

    /**
     * This function gets the customer's phone
     * @return mixed The customer's phone
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * This function sets the customer's phone
     * @param mixed $phone The customer's phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * This function gets the customer's city
     * @return mixed customer's city
     */
    public function getCity()
    {
        return $this->_city;
    }

    /**
     * This function sets the customer's city
     * @param mixed $city customer's city
     */
    public function setCity($city)
    {
        $this->_city = $city;
    }

    /**
     * This function gets the customer's state
     * @return mixed customer's state
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * This function sets the customer's state
     * @param mixed $state customer's state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * This function gets the customer's zip code
     * @return mixed customers zip code
     */
    public function getZip()
    {
        return $this->_zip;
    }

    /**
     * This function sets the customer's zip code
     * @param mixed $zip customers zip code
     */
    public function setZip($zip)
    {
        $this->_zip = $zip;
    }
}
