<?php

//Turn on error reporting -- this is critical!
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('DEBUG', 3);

//Default Route
$f3->route('GET /', function() {

    $view = new Template();
    echo $view->render('views/home.html');
});

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

//Run fat free
$f3->run();