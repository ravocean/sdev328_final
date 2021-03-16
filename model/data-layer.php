<?php
class DataLayer
{
    private $_dbh;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    function checkLoginCreds($email, $pass){
        //Query database
        $sql = "SELECT accountID, firstname, lastname, username, role FROM account WHERE username = :email AND password = sha1(:pass)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':email', strtolower($email), PDO::PARAM_STR);
        $statement->bindParam(':pass', $pass, PDO::PARAM_STR);

        //Process results
        $statement->execute();

        //Return
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function checkEmailExists($email){

        //Query database
        $sql = "SELECT accountID FROM account WHERE username = :email";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        //Process results
        $statement->execute();

        //RETURN
        return $statement->fetchAll(PDO::FETCH_ASSOC);;
    }

    function getUserVehicles($user){

        //Query database
        $sql = "SELECT firstname, lastname, year, make, model, mileage, maintenance, status FROM account NATURAL JOIN vehicle WHERE accountID = :accountID";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':accountID', $user['accountID'], PDO::PARAM_INT);

        //Process results
        $statement->execute();

        //RETURN
        return $statement->fetchAll(PDO::FETCH_ASSOC);;
    }

    function getOpenServiceTasks(){
        //Query database
        $sql = "SELECT firstname, lastname, year, make, model, mileage, maintenance, status FROM account NATURAL JOIN vehicle";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Process results
        $statement->execute();

        //RETURN
        return $statement->fetchAll(PDO::FETCH_ASSOC);;
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

    function saveAccount($account){
        //Build query
        $sql = "INSERT INTO account VALUES (null, :email, sha1(:pass), :first, :last, 0)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':email', $account->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':pass', $account->getPass(), PDO::PARAM_STR);
        $statement->bindParam(':first', $account->getFirstname(), PDO::PARAM_STR);
        $statement->bindParam(':last', $account->getLastname(), PDO::PARAM_STR);

        //Process results
        $statement->execute();

        //Return boolean
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function recoverAccount($email){

        //Setup the email information
        //Query database
        $sql = "SELECT firstname, lastname, password FROM account WHERE username = :email";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameter
        $statement->bindParam(':email', strtolower($email), PDO::PARAM_STR);

        //Process results
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC)[0];

        $fName = $result['firstname'];
        $pass = $result['password'];
        $to = $email;

        $subject = "Account Recovery Requested";
        $headers = "Name:  <myemail@somewhere.com>"; //replace with email variable

        $body = "Hello $fName, We've received a request to recover your password.\n";
        $body .= "Password: $pass";

        mail($to, $subject, $body, $headers);
    }
}