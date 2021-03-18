<?php

class Vehicle{

    private $_accountID;
    private $_year;
    private $_make;
    private $_model;
    private $_mileage;
    private $_maintenance;
    private $_status;

    /**
     * @return mixed
     */
    public function getAccountID()
    {
        return $this->_accountID;
    }

    /**
     * @param mixed $accountID
     */
    public function setAccountID($accountID)
    {
        $this->_accountID = $accountID;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->_year = $year;
    }

    /**
     * @return mixed
     */
    public function getMake()
    {
        return $this->_make;
    }

    /**
     * @param mixed $make
     */
    public function setMake($make)
    {
        $this->_make = $make;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }

    /**
     * @return mixed
     */
    public function getMileage()
    {
        return $this->_mileage;
    }

    /**
     * @param mixed $mileage
     */
    public function setMileage($mileage)
    {
        $this->_mileage = $mileage;
    }

    /**
     * @return mixed
     */
    public function getMaintenance()
    {
        return $this->_maintenance;
    }

    /**
     * @param mixed $maintenance
     */
    public function setMaintenance($maintenance)
    {
        $this->_maintenance = $maintenance;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->_status = $status;
    }
}