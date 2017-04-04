<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// PHP debug mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/../../functions/registry.php';

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
    
    //Get the values of the old timer from the id
    $oldTimer = $db->fetchRow('SELECT * FROM Timers WHERE id= :old', array('old' => $timerId));
    
    //Get all of the other POST values
    if(isset($_POST['Type'])) {
        $type = filter_input(INPUT_POST, "Type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($oldTimer['Type'] != $type && $type != NULL) {
            $db->update('Timers', array('id' => $oldTimer['id']), array('Type' => $type));
        }
    }

    if(isset($_POST['Stage'])) {
        $stage = filter_input(INPUT_POST, "Stage", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($oldTimer['Stage'] != $stage && $stage != NULL) {
            $db->update('Timers', array('id' => $oldTimer['id']), array('Stage' => $stage));
        }
    }

    if(isset($_POST['Region'])) {
        $region = filter_input(INPUT_POST, "Region", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($oldTimer['Region'] != $region && $region != NULL) {
            $db->update('Timers', array('id' => $oldTimer['id']), array('Region' => $region));
        }
    } 

    if(isset($_POST['System'])) {
        $system = filter_input(INPUT_POST, "System", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($oldTimer['System'] != $system && $system != NULL) {
            $db->update('Timers', array('id' => $oldTimer['id']), array('System' => $system));
        }
    }

    if(isset($_POST['Planet'])) {
        $planet = filter_input(INPUT_POST, "Planet", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($oldTimer['Planet'] != $planet && $planet != NULL) {
            $db->update('Timers', array('id' => $oldTimer['id']), array('Planet' => $planet));
        }
    } 

    if(isset($_POST['Moon'])) {
        $moon = filter_input(INPUT_POST, "Moon", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($oldTimer['Moon'] != $moon && $moon != NULL) {
            $db->update('Timers', array('id' => $oldTimer['id']), array('Moon' => $moon));
        }
    } 

    if(isset($_POST['Time'])) {
        $time = filter_input(INPUT_POST, "Time", FILTER_SANITIZE_SPECIAL_CHARS);
        $time = strtotime($time);
        if($oldTimer['Time'] != $time && $time != NULL) {
            $db->update('Timers', array('id' => $oldTimer['id']), array('Time' => $time));
        }
    } 

    if(isset($_POST['Notes'])) {
        $notes = filter_input(INPUT_POST, "Notes", FILTER_SANITIZE_SPECIAL_CHARS);
        if($oldTimer['Notes'] != $notes && $notes != NULL) {
            $db->update('Timers', array('id' => $oldTimer['id']), array('Notes' => $notes));
        }
    }
    
    //After all modifications are completed, set the header info
    $location = 'http://' . $_SERVER['HTTP_HOST'];
    $location = $location . dirname($_SERVER['PHP_SELF']) . '/../../timer/index.php';
    
} else {
    $timerId = NULL;
    $location = 'http://' . $_SERVER['HTTP_HOST'];
    $location = $location . dirname($_SERVER['PHP_SELF']) . '/../../timer/index.php';
}

//Go to the main site for timers in the timerboard
header("Location: $location");

?>