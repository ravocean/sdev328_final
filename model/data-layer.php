<?php
class DataLayer
{
    private $_dbh;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    function getLoginCred($email, $pass){
        //Query database
        $sql = "SELECT * FROM account WHERE username = :email AND password = :pass";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':pass', $pass, PDO::PARAM_STR);

        //Process results
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Return boolean
        return $result;
    }

    function getEmailCred($email){

        //Query database
        $sql = "SELECT accountID FROM account WHERE username = :email";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        //Process results
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //RETURN BOOLEAN
        return empty($result);
    }

    function saveAccount($account){
        //Build query
        $sql = "INSERT INTO account VALUES (null, :email, :pass, :first, :last)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':email', $account->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':pass', $account->getPass(), PDO::PARAM_STR);
        $statement->bindParam(':first', $account->getFirstname(), PDO::PARAM_STR);
        $statement->bindParam(':last', $account->getLastname(), PDO::PARAM_STR);

        //Process results
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Return boolean
        return $result;
    }

    function getStates()
    {
        return array('Alabama','Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado',
            'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana',
            'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts',
            'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana, Nebraska', 'Nevada',
            'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina',
            'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
            'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia',
            'Washington', 'West Virginia', 'Wisconsin', 'Wyoming');
    }
}