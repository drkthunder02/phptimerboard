<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// PHP debug mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/../functions/registry.php';

//Start the session
$session = new \Custom\Sessions\session();

//Open the database connection
$db = DBOpen();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}
//Get the parameters of the timer to be edited
if(isset($_POST['id'])) {
    $timerId = filter_input(INPUT_POST, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $timerId = NULL;
}

if(isset($_POST['Type'])) {
    $type = filter_input(INPUT_POST, "Type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $type = NULL;
}

if(isset($_POST['Stage'])) {
    $stage = filter_input(INPUT_POST, "Stage", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $stage = NULL;
}

if(isset($_POST['Region'])) {
    $region = filter_input(INPUT_POST, "Region", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $region = NULL;
}

if(isset($_POST['System'])) {
    $system = filter_input(INPUT_POST, "System", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $system = NULL;
}

if(isset($_POST['Planet'])) {
    $planet = filter_input(INPUT_POST, "Planet", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $planet = NULL;
}

if(isset($_POST['Moon'])) {
    $moon = filter_input(INPUT_POST, "Moon", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $moon = NULL;
}

if(isset($_POST['Time'])) {
    $time = filter_input(INPUT_POST, "Time", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $time = NULL;
}

if(isset($_POST['Notes'])) {
    $notes = filter_input(INPUT_POST, "Notes", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $notes = NULL;
}

