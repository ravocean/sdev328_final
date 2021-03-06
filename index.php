<?php

//Turn on error reporting -- this is critical!
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require files
require_once('vendor/autoload.php');

//Start Session
session_start();

//Connect to Server
require($_SERVER['DOCUMENT_ROOT'].'/../config.php');

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('DEBUG', 3);

$controller = new Controller($f3);
$dataLayer = new DataLayer($dbh);
$validator = new Validate();
$account = new Account();

//Default Route
$f3->route('GET /', function() {
    global $controller;
    $controller->home();
});

//Route to Login
$f3->route('GET|POST /login', function() {
    global $controller;
    $controller->login();
});

//Route to Account Creation
$f3->route('GET|POST /newAccount', function() {
    global $controller;
    $controller->newAccount();
});

//Route to User dashboard
$f3->route('GET|POST /userdash', function() {
    global $controller;
    $controller->userDash();
});

//Route to Admin dashboard
$f3->route('GET|POST /admindash', function() {
    global $controller;
    $controller->adminDash();
});







//Run fat free
$f3->run();




/*//Order 1 Route
$f3->route('GET /order', function($f3) {

    //Check if the form has been posted
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //validate the data
        if(empty($_POST['pet']))
        {

        }
        else{

        }
    }

    $colors = getColors();
    $f3->set('colors', $colors);

    $view = new Template();
    echo $view->render('views/pet-order.html');
});

//Order 2 Route
$f3->route('POST /order2', function() {

    //Verify 'pet' exists in the post array, if so save it to session
    if(isset($_POST['pet'])) {
        $_SESSION['pet'] = $_POST['pet'];
    }

    //Verify 'colors' exists in the post array, if so save it to session
    if(isset($_POST['colors'])) {
        $colors = $_POST['colors'];
        $colorSelected = null;
        foreach ($colors as $colorsArray) {
//            echo "$colorsArray";
            $_SESSION['colors'] = $colorsArray;
        }
    }

    $view = new Template();
    echo $view->render('views/pet-order2.html');
});*/
