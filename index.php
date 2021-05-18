<?php

//this is my controller for the cupcake website

//turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//require autoload file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');

//instantiate fat-free
$f3 = Base :: instance();

//define default route
$f3->route('GET|POST /' , function ($f3)
{

    //get the data from the model
    $f3->set('flavors', getFlavors());

    //display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

//run fat-free
$f3->run();