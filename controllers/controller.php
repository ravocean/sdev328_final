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
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function login()
    {
        global $dataLayer;
        global $account;

        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $dataLayer->checkLoginCred();
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

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            //Validate email  !! CHECK DATABASE
            if($validator->validEmail($_POST['email'])){
                $_SESSION['email'] = $_POST['email'];
                $dataLayer->checkUsername($_SESSION['email']);
            }
            else{
                $this->_f3->set("errors['email']", 'Please enter a valid email');
            }

            //Validate password !! CHECK DATABASE

            //Validate First and Last name

            //Validate Address 1 and 2

            //Validate City

            //Validate State

            //Validate Zip

            //IF ALL INFORMATION IS CORRECT, CREATE ACCOUNT AND CUSTOMER OBJECTS

            //Reroute
        }

        var_dump($_POST);

        //Render the page
        $view = new Template();
        echo $view->render('views/newAccount.html');
    }


    public function userDash(){
        $view = new Template();
        echo $view->render('views/userDash.html');
    }

    public function adminDash(){
        $view = new Template();
        echo $view->render('views/adminDash.html');
    }
}