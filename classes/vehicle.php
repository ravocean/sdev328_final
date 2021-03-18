<?php
/*
 * Desc:    Class Vehicle creates a vehicle object used to store vehicle information while scheduling
 *          a service in the SouthGarage App.
 * Date:    3/17/2021
 * File:    vehicle.php
 * Auth:    Ryan Rivera & Husrav Khomidov
 */
class Vehicle{

    private $_accountID;
    private $_year;
    private $_make;
    private $_model;
    private $_mileage;
    private $_service;
    private $_status;

    /**
     * This function gets the vehicle owner's accountID
     * @return mixed
     */
    public function getAccountID()
    {
        return $this->_accountID;
    }

    /**
     * This function sets the vehicle owner's accountID
     * @param mixed $accountID
     */
    public function setAccountID($accountID)
    {
        $this->_accountID = $accountID;
    }

    /**
     * This function gets the vehicle's year
     * @return mixed
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * This function sets the vehicle's year
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->_year = $year;
    }

    /**
     * This function gets the vehicle's make
     * @return mixed
     */
    public function getMake()
    {
        return $this->_make;
    }

    /**
     * This function sets the vehicle's make
     * @param mixed $make
     */
    public function setMake($make)
    {
        $this->_make = $make;
    }

    /**
     * This function gets the vehicle's model
     * @return mixed
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * This function sets the vehicle's model
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }

    /**
     * This function gets the vehicle's mileage
     * @return mixed
     */
    public function getMileage()
    {
        return $this->_mileage;
    }

    /**
     * This function sets the vehicle's mileage
     * @param mixed $mileage
     */
    public function setMileage($mileage)
    {
        $this->_mileage = $mileage;
    }

    /**
     * This function gets the vehicle's service
     * @return mixed
     */
    public function getService()
    {
        return $this->_service;
    }

    /**
     * This function sets the vehicle's service
     * @param mixed $maintenance
     */
    public function setService($maintenance)
    {
        $this->_service = $maintenance;
    }

    /**
     * This function gets the vehicle's status
     * @return mixed
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * This function sets the vehicle's status
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->_status = $status;
    }
}