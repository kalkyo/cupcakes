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
require_once ('model/validation.php');

//instantiate fat-free
$f3 = Base :: instance();

//define default route
$f3->route('GET|POST /' , function($f3)
{

    //Reinitialize a session array
    $_SESSION = array();

    //Initialize variables to store user input
    $userName = "";
    $userFlavors = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $userName = $_POST['name'];

        //if name is valid store data
        if (validName($_POST['name'])) {
            $_SESSION['name'] = $userName;
        }
        //set an error if not valid
        else {
            $f3->set('errors["name"]', 'Please enter a valid Name');
        }

        //if at least 1 flavor is selected and flavors are valid
        if (!empty($_POST['flavs']) && validFlavor($userFlavors))
        {
            //get user input
            $userFlavors = $_POST['flavs'];
            $_SESSION['userFlavors'] = $userFlavors;

            //get user input here
            $_SESSION['total'] = number_format((double)count($userFlavors) * 3.50, 2);

        }
        else {
            $f3->set('errors["flavs"]', 'Please select at least one flavor');
        }


        //If there are no errors redirect to summary route
        if (empty($f3->get('errors'))) {
            header('location: summary');
        }
    }

    //get the data from the model
    $f3->set('flavors', getFlavors());

    //store user input to hive
    $f3->set('userFlavors', $userFlavors);
    $f3->set('userName', $userName);

    //display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Summary page
$f3->route('GET /summary', function(){

    // Display the summary page
    $view = new Template();
    echo $view->render('views/summary.html');

});

//run fat-free
$f3->run();