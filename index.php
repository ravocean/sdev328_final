<?php
/*
 * Desc:    Class Controller displays page content for the SouthGarage App
 * Date:    3/1/21
 * File:    controller.php
 * Auth:    Ryan Rivera & Husrav Khomidov
 */

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload files
require_once('vendor/autoload.php');

//Start Session
session_start();

//Connect to Server
require($_SERVER['DOCUMENT_ROOT'].'/../config.php');

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('DEBUG', 3);

//Create instances of Controller, DataLayer, and Validate
$controller = new Controller($f3);
$dataLayer = new DataLayer($dbh);
$validator = new Validate();

//Default Route to Home
$f3->route('GET /', function()
{
    global $controller;
    $controller->home();
});

//Route to Login
$f3->route('GET|POST /login', function()
{
    global $controller;
    $controller->login();
});

//Route to Password Recovery
$f3->route('GET|POST /accountRecovery', function()
{
    global $controller;
    $controller->accountRecovery();
});

//Route to Account Creation
$f3->route('GET|POST /newAccount', function()
{
    global $controller;
    $controller->newAccount();
});

//Route to User dashboard
$f3->route('GET|POST /userdash', function()
{
    global $controller;
    $controller->userDash();
});

//Route to Admin dashboard
$f3->route('GET|POST /adminDash', function()
{
    global $controller;
    $controller->adminDash();
});

//Route to Logout
$f3->route('GET|POST /logout', function()
{
    global $controller;
    $controller->logout();
});

//Run fat free
$f3->run();