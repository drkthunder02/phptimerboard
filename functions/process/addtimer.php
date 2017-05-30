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

//Start a session
$session = new \Custom\Sessions\session();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

if(isset($_POST['Type'])) {
    $type = filter_input(INPUT_POST, 'Type');
} else {
    $type = "";
}

if(isset($_POST['Stage'])) {
    $stage = filter_input(INPUT_POST, 'Stage');
} else {
    $stage = "";
}

if(isset($_POST['Region'])) {
    $region = filter_input(INPUT_POST, 'Region');
} else {
    $region = "";
}

if(isset($_POST['System'])) {
    $system = filter_input(INPUT_POST, 'System');
} else {
    $system = "";
}

if(isset($_POST['Planet'])) {
    $planet = filter_input(INPUT_POST, 'Planet');
} else {
    $planet = "";
}

if(isset($_POST['Moon'])) {
    $moon = filter_input(INPUT_POST, 'Moon');
} else {
    $moon = "";
}

if(isset($_POST['Owner'])) {
    $owner = filter_input(INPUT_POST, 'Owner');
} else {
    $owner = "";
}

if(isset($_POST['EVE_Time'])) {
    $evetime = filter_input(INPUT_POST, 'EVE_Time');
} else {
    $evetime = "";
}

if(isset($_POST['Notes'])) {
    $notes = filter_input(INPUT_POST, 'Notes');
} else {
    $notes = "";
}

if(isset($_POST['User'])) {
    $user = filter_input(INPUT_POST, 'User');
} else {
    $user = "";
}

//Turn the $evetime from a regular date entered into seconds time only
$time = str_replace('/', '-', $time);
$time = strtotime($evetime);

$db = DBOpen();

$db->insert('Timers', array(
    'Type' => $type,
    'Stage' => $stage,
    'Region' => $region,
    'System' => $system,
    'Planet' => $planet,
    'Moon' => $moon,
    'Owner' => $owner,
    'EVETime' => $time,
    'Notes' => $notes,
    'User' => $user
));

DBClose($db);

//Go to the main site for timers in the timerboard
$location = 'http://' . $_SERVER['HTTP_HOST'];
$location = $location . dirname($_SERVER['PHP_SELF']) . '/../../timer/index.php';
header("Location: $location");

?>
