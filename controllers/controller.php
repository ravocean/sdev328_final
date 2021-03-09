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
                $this->_f3->set("errors['pass']", 'Please enter a password');
            }

            //If both email and password are valid
            if(empty($this->_f3->get('errors'))){

                //Check account database for a match
                if($dataLayer->checkLoginCred($_SESSION['email'], $_SESSION['pass'])){

                    //TESTING - return accountID to use as session ID
                    $result = $dataLayer->checkLoginCred($_SESSION['email'], $_SESSION['pass']);
                    echo $result[0]['accountID'];

                    //TODO: Query database for account info, put in account object

                    //TODO: Implement Session ID Before Reroute
                    $this->_f3->reroute('userDash');
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

    function newAccount(){
        global $dataLayer;
        global $validator;
        global $account;

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

            //Validate First Name, if valid add to account
            $account->setFirstname($validator->validName($_POST['fName']) ?
                $_POST['fName'] : $this->_f3->set("errors['fName']", 'Please enter your first name'));

            //Validate Last Name, if valid add to account
            $account->setLastname($validator->validName($_POST['lName']) ?
                $_POST['lName'] : $this->_f3->set("errors['lName']", 'Please enter your last name'));

            //Validate email
            if($validator->validEmail($_POST['email'])){

                //If email is not in the account table add to account, otherwise set error message
                $account->setEmail($dataLayer->checkEmailCred($_POST['email']) ?
                    $_POST['email'] : $this->_f3->set("errors['email']", 'Email is already in use.'));
            }
            //Email is not valid, set error message
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }

            //Validate password
            if($validator->validPass($_POST['passConfirm'])){

                //If passwords match, add to account, otherwise set error message
                $account->setPass($_POST['pass'] === $_POST['passConfirm'] ?
                    $_POST['pass'] : $this->_f3->set("errors['passConfirm']", 'The passwords do not match'));
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

                //TODO: Implement Session Before Reroute

                //Save account to $f3
                $this->_f3->set('account', $account);

                //TODO: Either reroute to login or dashboard

                //Reroute
                $this->_f3->reroute('login');
            }
        }

//        var_dump($_POST);
        //Render the page
        $view = new Template();
        echo $view->render('views/newAccount.html');
    }

    public function userDash(){
        //Set the page title
        $this->_f3->set("title", "User Dashboard");

        $view = new Template();
        echo $view->render('views/userDash.html');
    }

    public function adminDash(){
        //Set the page title
        $this->_f3->set("title", "Admin Dashboard");

        $view = new Template();
        echo $view->render('views/adminDash.html');
    }
}