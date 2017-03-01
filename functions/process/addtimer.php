<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../functions/registry.php';

//Start a session
$session = new \Custom\Sessions\session();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

if(isset($_POST['Type'])) {
    $type = filter_input(POST, 'Type');
} else {
    $type = "Defensive";
}

if(isset($_POST['Stage'])) {
    $stage = filter_input(POST, 'Stage');
}

if(isset($_POST['Region'])) {
    $region = filter_input(POST, 'Region');
} else {
    $region = "";
}

if(isset($_POST['System'])) {
    $system = filter_input(POST, 'System');
} else {
    $system = "";
}

if(isset($_POST['Planet'])) {
    $planet = filter_input(POST, 'Planet');
} else {
    $planet = "";
}

if(isset($_POST['Moon'])) {
    $moon = filter_input(POST, 'Moon');
} else {
    $moon = "";
}

if(isset($_POST['Owner'])) {
    $owner = filter_input(POST, 'Owner');
} else {
    $owner = "";
}

if(isset($_POST['EVE_Time'])) {
    $evetime = filter_input(POST, 'EVE_Time');
} else {
    $evetime = "";
}

if(isset($_POST['Notes'])) {
    $notes = filter_input(POST, 'Notes');
} else {
    $notes = "";
}

if(isset($_POST['User'])) {
    $user = filter_input(POST, 'User');
} else {
    $user = "";
}

//Turn the $evetime from a regular date entered into seconds time only
//echo strtotime("2014-01-01 00:00:01")."<hr>";
// output is 1388516401
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
$location = $location . dirname($_SERVER['PHP_SELF']) . '/timer/index.php';
header("Location: $location");

?>
