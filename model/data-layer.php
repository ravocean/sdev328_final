<?php
/*
 * Desc:    Class DataLayer creates an object that is used to execute validation and database queries
 *          for the SouthGarage App.
 * Date:    3/1/21
 * File:    data-layer.php
 * Auth:    Ryan Rivera & Husrav Khomidov
 */
class DataLayer
{
    private $_dbh;

    /**
     * DataLayer constructor.
     * @param $dbh Object fat-free hive
     */
    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    /**
     * This function checks a database table for an entry matching the supplied email and password
     * to allow a log in
     * @param $email String email
     * @param $pass String password
     * @return mixed accountID
     */
    function checkLoginCreds($email, $pass)
    {
        //Create a query for the database table
        $sql = "SELECT accountID, firstname, lastname, username, role
                FROM account WHERE username = :email AND password = sha1(:pass)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':email', strtolower($email), PDO::PARAM_STR);
        $statement->bindParam(':pass', $pass, PDO::PARAM_STR);

        //Process the results
        $statement->execute();

        //Return the results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function checks a database table for an entry matching the supplied email to
     * prevent duplicate email entries in the table during account creation
     * @param $email String email
     * @return mixed accountID
     */
    function checkEmailExists($email)
    {
        //Create a query for the database table
        $sql = "SELECT accountID FROM account WHERE username = :email";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        //Process the results
        $statement->execute();

        //Return the results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function gets all vehicle database table entries
     * @return array array of all vehicle table entries
     */
    function getOpenServiceTasks()
    {
        //Create a query for the database table
        $sql = "SELECT accountID, firstname, lastname, year, make, model, mileage, maintenance, status 
                FROM account NATURAL JOIN vehicle";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Process results
        $statement->execute();

        //Return the results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function gets all user information from the account database table where entries
     * role = 0 (regular user).
     * @return mixed Array of account table entries
     */
    function getUsers()
    {
        //Create a query for the database table
        $sql = "SELECT * FROM account WHERE role = 0 ORDER BY firstname";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Process results
        $statement->execute();

        //Return the results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function gets all vehicle database table entries matching the supplied user accountID
     * @param $userID int user's accountID
     * @return array array of database entries
     */
    function getUserVehicles($userID)
    {
        //Create a query for the database table
        $sql = "SELECT accountID, vehicleID, firstname, lastname, year, make, model, mileage, maintenance, status FROM account NATURAL JOIN vehicle WHERE accountID = :accountID";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':accountID', $userID, PDO::PARAM_INT);

        //Process the results
        $statement->execute();

        //Return the results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function inserts a account entry into a database table using a supplied account object
     * @param $account Object account object
     */
    function saveAccount($account)
    {
        //Create a query for the database table
        $sql = "INSERT INTO account VALUES (null, :email, sha1(:pass), :first, :last, :role)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':email', $account->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':pass', $account->getPass(), PDO::PARAM_STR);
        $statement->bindParam(':first', $account->getFirstname(), PDO::PARAM_STR);
        $statement->bindParam(':last', $account->getLastname(), PDO::PARAM_STR);
        $statement->bindParam(':role', $account->getRole(), PDO::PARAM_INT);

        //Process the results
        $statement->execute();
    }

    /**
     * This function will check a database table for a matching email entry, then send that email
     * a account recovery message.
     * @param $email String email
     */
    function recoverAccount($email)
    {
        //Create a query for the database table
        $sql = "SELECT firstname, lastname, password FROM account WHERE username = :email";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':email', strtolower($email), PDO::PARAM_STR);

        //Process the results
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC)[0];

        //Create an account recovery email
        $fName = $result['firstname'];
        $pass = $result['password'];
        $to = $email;
        $subject = "Account Recovery Requested";
        $headers = "Name:  <myemail@somewhere.com>"; //replace with email variable
        $body = "Hello $fName, We've received a request to recover your password.\n";
        $body .= "Password: $pass";

        //Send account recovery email
        mail($to, $subject, $body, $headers);
    }

    /**
     * This function inserts a vehicle entry into a database table using a supplied vehicle object
     * @param $vehicle Object vehicle object
     */
    function saveVehicle($vehicle)
    {
        //Create a query for the database table
        $sql = "INSERT INTO vehicle VALUES (null, :accountID, :year, :make, :model, :mileage, :service, :status)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':accountID', $vehicle->getAccountID(), PDO::PARAM_STR);
        $statement->bindParam(':make', $vehicle->getMake(), PDO::PARAM_STR);
        $statement->bindParam(':model', $vehicle->getModel(), PDO::PARAM_STR);
        $statement->bindParam(':year', $vehicle->getYear(), PDO::PARAM_STR);
        $statement->bindParam(':mileage', $vehicle->getMileage(), PDO::PARAM_STR);
        $statement->bindParam(':service', $vehicle->getService(), PDO::PARAM_STR);
        $statement->bindParam(':status', $vehicle->getStatus(), PDO::PARAM_STR);

        //Process the results
        $statement->execute();
    }

    /**
     * This function provides an array of states
     * @return string[] of all states
     */
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