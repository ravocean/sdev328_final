<?php
/*
 * Desc:    Class Controller displays page content for the SouthGarage App
 * Date:    3/1/21
 * File:    controller.php
 * Auth:    Ryan Rivera & Husrav Khomidov
 */

class Controller
{
    private $_f3;

    /**
     * Controller constructor.
     * @param $f3 Object fat-free hive
     */
    public function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    /**
     * This function displays the home page
     */
    public function home()
    {
        //Set the page title
        $this->_f3->set("title", "South Garage");

        //Render the page
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * This function displays the login page
     */
    function login()
    {
        //If already logged in, redirect to the appropriate page
        if(isset($_SESSION['user'])) {
            $this->_f3->reroute($_SESSION['user']['role'] == 0 ? '/userDash' : '/adminDash');
        }

        //Access globals
        global $dataLayer;
        global $validator;

        //Set the page title
        $this->_f3->set("title", "Login");

        //Set Sticky Forms
        $this->_f3->set("email", isset($_POST['email']) ? $_POST['email'] : "");
        $this->_f3->set("pass", isset($_POST['pass']) ? $_POST['pass'] : "");

        //If the POST array is set
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            //Validate email, if valid set to SESSION, else display error
            if($validator->validEmail($_POST['email'])){
                $_SESSION['email'] = $_POST['email'];
            }
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }

            //Validate password, if valid set to SESSION, else display error
            if($validator->validPass($_POST['pass'])){
                $_SESSION['pass'] = $_POST['pass'];
            }
            else{
                $this->_f3->set("errors['pass']", 'Please enter a valid password');
            }

            //If both email and password are valid
            if(empty($this->_f3->get('errors'))){

                //Query database for an account ID matching the email and password
                $accountID = $dataLayer->checkLoginCreds($_SESSION['email'], $_SESSION['pass']);

                //If result is not empty, an accountID was found
                if(!empty($accountID)){

                    //Save the result to SESSION to indicate user is logged in
                    $_SESSION['user'] = $accountID[0];

                    //Reroute user depending on their role to either userDash or adminDash
                    if($_SESSION['user']['role'] == 0){
                        $this->_f3->reroute('userDash');
                    }
                    else{
                        $this->_f3->reroute('adminDash');
                    }
                }
                //If email and password pair do not exist in the database, display error
                else{
                    $this->_f3->set("errors['email']", 'The email or password you entered isn\'t 
                    connected to an account.');
                }
            }
        }

        //Render the page
        $view = new Template();
        echo $view->render('views/login.html');
    }

    /**
     *This function displays the logout page
     */
    function logout()
    {
        //Destroy the SESSION to clear user information
        session_destroy();

        //Set SESSION to an empty array for good measure
        $_SESSION = array();

        //Reroute to login page
        $this->_f3->reroute('login');
    }

    /**
     * This function displays the newAccount page
     */
    function newAccount()
    {
        //If logged in, redirect to appropriate page
        if(isset($_SESSION['user'])) {
            $this->_f3->reroute($_SESSION['user']['role'] == 0 ? '/userDash' : '/adminDash');
        }

        //Access globals
        global $dataLayer;
        global $validator;

        //Set the page title
        $this->_f3->set("title", "Create Account");
        $this->_f3->set('listStates', $dataLayer->getStates());

        //Sticky Forms
        $this->_f3->set("email", isset($_POST['email']) ? $_POST['email'] : "");
        $this->_f3->set("pass", isset($_POST['pass']) ? $_POST['pass'] : "");
        $this->_f3->set("passConfirm", isset($_POST['passConfirm']) ? $_POST['passConfirm'] : "");
        $this->_f3->set("fName", isset($_POST['fName']) ? $_POST['fName'] : "");
        $this->_f3->set("lName", isset($_POST['lName']) ? $_POST['lName'] : "");
        $this->_f3->set("isAdmin", isset($_POST['isAdmin']) ? $_POST['isAdmin'] : null);

        $this->_f3->set("address1", isset($_POST['address1']) ? $_POST['address1'] : "");
        $this->_f3->set("address2", isset($_POST['address2']) ? $_POST['address2'] : "");
        $this->_f3->set("city", isset($_POST['city']) ? $_POST['city'] : "");
        $this->_f3->set("state", isset($_POST['state']) ? $_POST['state'] : "");
        $this->_f3->set("zip", isset($_POST['zip']) ? $_POST['zip'] : "");
        $this->_f3->set("phone", isset($_POST['phone']) ? $_POST['phone'] : "");

        //If the POST array is set
        if($_SERVER['REQUEST_METHOD'] == "POST") {


            if(isset($_POST['isAdmin'])){
                $account = new Account();
            }
            else{
                $account = new Customer();

                //Validate Address 1, if not empty add both address inputs to customer, else display error
                if(!empty($_POST['address1'])){
                    $account->setAddress1($_POST['address1']);
                    $account->setAddress2($_POST['address2']);
                }
                else{
                    $this->_f3->set("errors['address1']", 'Please Enter an Address');
                }

                //Validate City, if not empty add to customer, else display error
                if(!empty($_POST['city'])){
                    $account->setCity($_POST['city']);
                }
                else{
                    $this->_f3->set("errors['city']", 'Please Enter a city');
                }

                //Validate State, if valid add to customer, else display error
                if($validator->validState($_POST['state'])){
                    $account->setState($_POST['state']);
                }
                else{
                    $this->_f3->set("errors['state']", 'Please Select a State');
                }

                //Validate Zip
                if($validator->validZip($_POST['zip'])){
                    $account->setZip($_POST['zip']);
                }
                else{
                    $this->_f3->set("errors['zip']", 'Please Enter a zip code');
                }

                //Validate Phone
                if($validator->validPhone($_POST['phone'])){
                    $account->setPhone($_POST['phone']);
                }
                else{
                    $this->_f3->set("errors['phone']", 'Please Enter a 10 digit phone number');
                }
            }

            //Validate first name, if valid add to account, else display error
            if($validator->validName($_POST['fName'])){
                $account->setFirstname(ucfirst(strtolower($_POST['fName'])));
            }
            else{
                $this->_f3->set("errors['fName']", 'Please enter a valid first name');
            }

            //Validate last name, if valid add to account, else display error
            if($validator->validName($_POST['lName'])){
                $account->setLastname(ucfirst(strtolower($_POST['lName'])));
            }
            else{
                $this->_f3->set("errors['lName']", 'Please enter a valid last name');
            }

            //Validate email, else display error
            if($validator->validEmail($_POST['email'])){
                //If email is not in use add to account, else display error
                if(empty($dataLayer->checkEmailExists($_POST['email']))){
                    $account->setEmail(strtolower($_POST['email']));
                }
                else{
                    $this->_f3->set("errors['email']", 'Email is already in use.');
                }
            }
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }

            //Validate password, else display error
            if($validator->validPass($_POST['pass'])){
                //If passwords match, add to account, else display error
                if($_POST['pass'] === $_POST['passConfirm']){
                    $account->setPass($_POST['pass']);
                }
                else{
                    $this->_f3->set("errors['passConfirm']", 'The passwords do not match');
                }
            }
            else{
                $this->_f3->set("errors['pass']", 'Please enter a valid password');
            }

            //If Admin is selected, set account role to 1 for admin, else 0 for user
            $account->setRole(isset($_POST['isAdmin']) ? 1 : 0);

            //If no errors are set
            if(empty($this->_f3->get('errors'))){

                //Save account to database
                $dataLayer->saveAccount($account);

                //Save account to f3 hive
                $this->_f3->set('account', $account);

                //Reroute to login
                $this->_f3->reroute('login');
            }
        }

//        var_dump($_POST);

        //Render the page
        $view = new Template();
        echo $view->render('views/newAccount.html');
    }

    /**
     * This function display the userDash page
     */
    public function userDash()
    {
        //If not logged in as a user, redirect to login page
        if($_SESSION['user']['role'] != 0){
            $this->_f3->reroute('login');
        }

        //Access globals
        global $dataLayer;

        //Set the page title
        $this->_f3->set("title", "User Dashboard");

        //Sticky Forms
        $this->_f3->set("vMake", isset($_POST['vMake']) ? $_POST['vMake'] : "");
        $this->_f3->set("vModel", isset($_POST['vModel']) ? $_POST['vModel'] : "");
        $this->_f3->set("vYear", isset($_POST['vYear']) ? $_POST['vYear'] : "");
        $this->_f3->set("vMileage", isset($_POST['vMileage']) ? $_POST['vMileage'] : "");
//        $this->_f3->set("vService", isset($_POST['vService']) ? $_POST['vService'] : "");

        //If the POST array is set
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            //Create a Vehicle object to save vehicle data to.
            $vehicle = new Vehicle();

            //Set the vehicle data
            $vehicle->setAccountID($_SESSION['user']['accountID']);
            $vehicle->setMake($_POST['vMake']);
            $vehicle->setModel($_POST['vModel']);
            $vehicle->setYear($_POST['vYear']);
            $vehicle->setMileage($_POST['vMileage']);
            $vehicle->setService(implode(", ", $_POST['vService']));
            $vehicle->setStatus('Awaiting Inspection');

            //Save vehicle to database
            $dataLayer->saveVehicle($vehicle);
        }

        //Get user vehicles from database, save to f3 hive.
        $this->_f3->set('results', $dataLayer->getUserVehicles($_SESSION['user']['accountID']));

        //Render the page
        $view = new Template();
        echo $view->render('views/userDash.html');
    }

    /**
     * This function displays the adminDash page
     */
    public function adminDash()
    {
        //If not logged in as a admin, redirect to login page
        if($_SESSION['user']['role'] != 1){
            $this->_f3->reroute('login');
        }

        //Access globals
        global $dataLayer;

        //Set the page title
        $this->_f3->set("title", "Admin Dashboard");

        //Get all vehicles from database, save to f3 hive to populate the open tickets table.
//        $this->_f3->set('results', $dataLayer->getOpenServiceTasks());

        //Get users from database, save to f3 hive to populate the user select element
        $this->_f3->set('listUsers', $dataLayer->getUsers());

        //If a user has been selected, get the user's vehicles and save to f3 hive to populate user table
//        if(isset($_POST['userID'])){
//            $this->_f3->set("userVehicles", $dataLayer->getUserVehicles($_POST['userID']));
//        }

        //Render the page
        $view = new Template();
        echo $view->render('views/adminDash.html');
    }

    /**
     * This function displays the accountRecovery page
     */
    public function accountRecovery()
    {
        //Access globals
        global $validator;
        global $dataLayer;

        //Set the page title
        $this->_f3->set("title", "Account Recovery");

        //Sticky Forms
        $this->_f3->set("email", isset($_POST['email']) ? $_POST['email'] : "");

        //If the POST array is set
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            //Validate email, else display error
            if($validator->validEmail($_POST['email'])){

                //Display message that the email has been sent if account exists
                $this->_f3->set("recovery", 'If an account is associated with this email address, an email will be
                sent containing further instructions on the recovery process.');

                //If account exists, send recovery email message
                if(!empty($dataLayer->checkEmailExists($_POST['email']))){

//                    $dataLayer->recoverAccount($_POST['email']);
                }
            }
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }
        }

        //Render the page
        $view = new Template();
        echo $view->render('views/accountRecovery.html');
    }
}