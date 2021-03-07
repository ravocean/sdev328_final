<?php
class DataLayer
{
    private $_dbh;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    //WORKING!!!!!!!!!!!!!!!!!!!
    function checkLoginCred($email, $pass){
        //Query database
        $sql = "SELECT firstname FROM account WHERE username = :email AND password = :pass";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':pass', $pass, PDO::PARAM_STR);

        //Process results
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        //Return boolean
        return !empty($result);
    }


//    function checkUsername($email, $pass){
//
//        //Query database
//        $sql = "SELECT firstname FROM account WHERE username = :email";
//
//        //prepare the statement
//        $statement = $this->_dbh->prepare($sql);
//
//        //bind the parameter
//        $statement->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
//        $statement->bindParam(':pass', $_POST['pass'], PDO::PARAM_STR);
//
//        //Process results
//        $statement->execute();
//        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
//
//        var_dump($result);
//        //RETURN BOOLEAN
//    }


//
//    function newAccount()
//    {
//        //Query database
//        $sql = "INSERT INTO account (null, :user, :pass, :first, :last)";
//
//        //prepare the statement
//        $statement = $dbh->prepare($sql);
//
//        //bind the parameter
//        $statement->bindParam(':user', $_POST['user'], PDO::PARAM_STR);
//        $statement->bindParam(':pass', $_POST['pass'], PDO::PARAM_STR);
//        $statement->bindParam(':first', $_POST['first'], PDO::PARAM_STR);
//        $statement->bindParam(':last', $_POST['last'], PDO::PARAM_STR);
//
//        //Process results
//        $statement->execute();
//        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
//    }

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

