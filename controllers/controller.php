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
                    echo "USER EXISTS";
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

        //Load states into $f3
        $this->_f3->set("listStates", $dataLayer->getStates());

        //Set the page title
        $this->_f3->set("title", "Create Account");

        //Sticky Forms
        $this->_f3->set("email", isset($_POST['email']) ? $_POST['email'] : "");
        $this->_f3->set("pass", isset($_POST['pass']) ? $_POST['pass'] : "");
        $this->_f3->set("passConfirm", isset($_POST['passConfirm']) ? $_POST['passConfirm'] : "");
        $this->_f3->set("fName", isset($_POST['fName']) ? $_POST['fName'] : "");
        $this->_f3->set("lName", isset($_POST['lName']) ? $_POST['lName'] : "");
        $this->_f3->set("address1", isset($_POST['address1']) ? $_POST['address1'] : "");
        $this->_f3->set("address2", isset($_POST['address2']) ? $_POST['address2'] : "");
        $this->_f3->set("city", isset($_POST['city']) ? $_POST['city'] : "");
        $this->_f3->set("state", isset($_POST['state']) ? $_POST['state'] : "");
        $this->_f3->set("zip", isset($_POST['zip']) ? $_POST['zip'] : "");

        //If POST array is set
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $passConfirm = $_POST['passConfirm'];


            //Validate email
            if($validator->validEmail($email)){
                //If email is not in the account table add to SESSION, otherwise set error message
                if($dataLayer->checkEmailCred($email)){
                    $_SESSION['email'] = $email;
                }
                else{
                    $this->_f3->set("errors['email']", 'Email is already in use.');
                }
            }
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }

            //Validate password
            if($validator->validPass($pass)){
                //If passwords match, add to SESSION, otherwise set error message
                if($pass === $passConfirm){
                    $_SESSION = $pass;
                }
                else{
                    $this->_f3->set("errors['passConfirm']", 'The passwords do not match');
                }
            }
            else{
                $this->_f3->set("errors['pass']", 'Please enter a valid password');
            }

            //Validate First and Last name

            //Validate Address 1 and 2

            //Validate City

            //Validate State

            //Validate Zip

            //IF ALL INFORMATION IS CORRECT, CREATE ACCOUNT AND CUSTOMER OBJECTS

            //Reroute
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