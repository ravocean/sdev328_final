<?php
/*
 * Desc:    Class DataLayer provides validation functions for the SouthGarage App.
 * Date:    3/1/21
 * File:    validate.php
 * Auth:    Ryan Rivera & Husrav Khomidov
 */
class Validate
{
    /**
     * Checks that the supplied name is a String containing only alphabetic characters
     * @param $name String to validate as a valid name
     * @return boolean true or false if valid
     */
    function validName($name)
    {
        //Verify $name is not empty and is only alphabetical characters
        return !empty($name) && ctype_alpha($name);
    }

    /**
     * Checks that a supplied Number is a valid phone number containing 10 numbers
     * @param $phone Number to validate as a valid phone number
     * @return boolean true if valid, false otherwise
     */
    function validPhone($phone)
    {
        //Verify phone number is numeric and has a length of 10
        return is_numeric($phone) && strlen((string)$phone) == 10;
    }

    /**
     * Checks that a supplied state exists in the data-layer.php
     * @param $state String supplied state
     * @return bool true if state is valid, false otherwise
     */
    function validState($state)
    {
        global $dataLayer;
        //Verify state matches the available states in data-layer.php
        return in_array($state, $dataLayer->getStates());
    }

    /**
     * Checks that a supplied String is a valid email address
     * @param $email String to validate as a valid email address
     * @return boolean true if email contains proper format, false otherwise
     */
    function validEmail($email)
    {
        //Validate email address format
        $patternEmail = '^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$^';
        return preg_match($patternEmail, $email);
    }

    /**
     * Checks that a supplied password is not blank.
     * @param $pass String - supplied password
     * @return bool true if password is not empty, false otherwise
     */
    function validPass($pass)
    {
        $patternPass = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[$!@#%&*\^]).{8,32}$/';
        return preg_match($patternPass, $pass);
    }

    /**
     * Checks that a supplied zip code is valid
     * @param $zip customer's zip code
     * @return boolean if zip code is valid
     */
    function validZip($zip)
    {
        $patternZip = '^[0-9]{5}(?:-[0-9]{4})?$^';
        return preg_match($patternZip, $zip);
    }
}