<?php
/*
 * Desc:    Class Controller displays page content for the
 * Date:
 * File:    controller.php
 * Auth:    Ryan Rivera
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

    public function home(){
        //Set the page title
        $this->_f3->set("title", "South Garage");

        $view = new Template();
        echo $view->render('views/home.html');
    }

    function login()
    {
        global $dataLayer;
        global $validator;

        //Set the page title
        $this->_f3->set("title", "Login");
        $this->_f3->set("email", isset($_POST['email']) ? $_POST['email'] : "");
        $this->_f3->set("pass", isset($_POST['pass']) ? $_POST['pass'] : "");

        //If POST array is set
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            //Validate email
            if($validator->validEmail($_POST['email'])){
                $_SESSION['email'] = $_POST['email'];
            }
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }

            //Validate password
            if($validator->validPass($_POST['pass'])){
                $_SESSION['pass'] = $_POST['pass'];
            }
            else{
                $this->_f3->set("errors['pass']", 'Please enter a valid password');
            }

            //If both email and password are valid
            if(empty($this->_f3->get('errors'))){

                //Query database for account ID matching provided email and password, save result
                $accountID = $dataLayer->checkLoginCreds($_SESSION['email'], $_SESSION['pass']);

                //If result is not empty
                if(!empty($accountID)){

                    //Save result to SESSION to indicate user is logged in
                    $_SESSION['user'] = $accountID[0];
                }
                //If email and password pair do not exist in the database, display error
                else{
                    $this->_f3->set("errors['email']", 'The email or password you entered isn\'t 
                    connected to an account.');
                }
            }
        }

        //If a user is already logged in, redirect to the appropriate dashboard
        if(isset($_SESSION['user'])){
            if($_SESSION['user']['role'] == 0){
                $this->_f3->reroute('userDash');
            }
            else{
                $this->_f3->reroute('adminDash');
            }
        }

        //Render the page
        $view = new Template();
        echo $view->render('views/login.html');
    }

    function logout(){
        session_destroy();
        $_SESSION = array();
        $this->_f3->reroute('login');
    }

    function newAccount(){

        global $dataLayer;
        global $validator;

        //Set the page title
        $this->_f3->set("title", "Create Account");

        //Sticky Forms
        $this->_f3->set("email", isset($_POST['email']) ? $_POST['email'] : "");
        $this->_f3->set("pass", isset($_POST['pass']) ? $_POST['pass'] : "");
        $this->_f3->set("passConfirm", isset($_POST['passConfirm']) ? $_POST['passConfirm'] : "");
        $this->_f3->set("fName", isset($_POST['fName']) ? $_POST['fName'] : "");
        $this->_f3->set("lName", isset($_POST['lName']) ? $_POST['lName'] : "");

        //If POST array is set
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            //Instantiate Account object to save user data to.
            $account = new Account();

            //Validate First Name, if valid add to account
            if($validator->validName($_POST['fName'])){
                $account->setFirstname(ucfirst(strtolower($_POST['fName'])));
            }
            else{
                $this->_f3->set("errors['fName']", 'Please enter a valid first name');
            }

            //Validate Last Name, if valid add to account
            if($validator->validName($_POST['lName'])){
                $account->setLastname(ucfirst(strtolower($_POST['lName'])));
            }
            else{
                $this->_f3->set("errors['lName']", 'Please enter a valid last name');
            }

            //Validate email
            if($validator->validEmail($_POST['email'])){
                //If email is not in the account table add to account, otherwise set error message
                if(empty($dataLayer->checkEmailExists($_POST['email']))){
                    $account->setEmail(strtolower($_POST['email']));
                }
                else{
                    $this->_f3->set("errors['email']", 'Email is already in use.');
                }
            }
            //Email is not valid, set error message
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }

            //Validate password
            if($validator->validPass($_POST['pass'])){
                //If passwords match, add to account, otherwise set error message
                if($_POST['pass'] === $_POST['passConfirm']){
                    $account->setPass($_POST['pass']);
                }
                else{
                    $this->_f3->set("errors['passConfirm']", 'The passwords do not match');
                }
            }
            //Password is not valid, set error message
            else{
                $this->_f3->set("errors['pass']", 'Please enter a valid password');
            }

            //Reroute
            if(empty($this->_f3->get('errors'))){

                //TODO: Verify account save executed properly, display message appropriately
                //Save account to database
                $dataLayer->saveAccount($account);

                //Save account to $f3
                $this->_f3->set('account', $account);

                //Reroute
                $this->_f3->reroute('login');
            }
        }

        //Render the page
        $view = new Template();
        echo $view->render('views/newAccount.html');
    }

    public function userDash(){
        //Reroute if not a user account
        if($_SESSION['user']['role'] != 0){
            $this->_f3->reroute('/');
        }

        //Set the page title
        $this->_f3->set("title", "User Dashboard");

        global $dataLayer;

        //Get user vehicles from database, save to f3 hive.
        $this->_f3->set('results', $dataLayer->getUserVehicles($_SESSION['user']));

        $view = new Template();
        echo $view->render('views/userDash.html');
    }

    public function adminDash(){
        //Reroute if not a admin account
        if($_SESSION['user']['role'] != 1){
            $this->_f3->reroute('/');
        }

        //Set the page title
        $this->_f3->set("title", "Admin Dashboard");

        global $dataLayer;

        //Get user vehicles from database, save to f3 hive.
        $this->_f3->set('results', $dataLayer->getOpenServiceTasks());

        $view = new Template();
        echo $view->render('views/adminDash.html');
    }

    public function accountRecovery(){
        global $validator;
        global $dataLayer;

        //Set the page title
        $this->_f3->set("title", "Account Recovery");
        //Sticky Forms
        $this->_f3->set("email", isset($_POST['email']) ? $_POST['email'] : "");

        //If POST array is set
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            //Validate email
            if($validator->validEmail($_POST['email'])){

                //Display message that the email has been sent if account exists
                $this->_f3->set("recovery", 'If an account is associated with this email address, an email will be
                sent containing further instructions on the recovery process.');

                //If account exists, send recovery email
                if(!empty($dataLayer->checkEmailExists($_POST['email']))){
                    $dataLayer->recoverAccount($_POST['email']);
                }
            }
            //Email is not valid, set error message
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }
        }

        $view = new Template();
        echo $view->render('views/accountRecovery.html');
    }

    //TODO: This route is for testing adding vehicles to table
    public function addVehicle(){

        global $dataLayer;

        //Set the page title
        $this->_f3->set("title", "Create Account");

        //Sticky Forms
        $this->_f3->set("vMake", isset($_POST['vMake']) ? $_POST['vMake'] : "");
        $this->_f3->set("vModel", isset($_POST['vModel']) ? $_POST['vModel'] : "");
        $this->_f3->set("vYear", isset($_POST['vYear']) ? $_POST['vYear'] : "");
        $this->_f3->set("vMileage", isset($_POST['vMileage']) ? $_POST['vMileage'] : "");
        $this->_f3->set("vService", isset($_POST['vService']) ? $_POST['vService'] : "");

        //If POST array is set
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            //Instantiate Account object to save user data to.
            $vehicle = new Vehicle();

            $vehicle->setAccountID($_SESSION['user']['accountID']);
            $vehicle->setMake($_POST['vMake']);
            $vehicle->setModel($_POST['vModel']);
            $vehicle->setYear($_POST['vYear']);
            $vehicle->setMileage($_POST['vMileage']);
            $vehicle->setService($_POST['vService']);
            $vehicle->setStatus('Awaiting Inspection');
            $dataLayer->addVehicle($vehicle);
//            var_dump($vehicle);

        }

        //Render the page
        $view = new Template();
        echo $view->render('views/addVehicle.html');
    }
}