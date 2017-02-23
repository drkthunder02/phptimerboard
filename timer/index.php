<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../functions/registry.php';

//Start the session
$session = new \Custom\Sessions\session();

PrintHTMLHeaderLogged();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}
//Print the navbar
PrintNavBarLogged($_SESSION['Character'], $_SESSION['AccessLevel']);

$currentTime = time();

//Print out the timers that are going on currently since we have printed out the navigation bar at the top
$timers = $db->fetchRowMany('SELECT * FROM Timers WHERE EVETime >= :now', array('now' => $currentTime));
foreach($timers as $timer) {
    
}

$_SESSION['logged'] = true;
$_SESSION['Character'] = $char['name'];
$_SESSION['CharacterID'] = $charID;
$_SESSION['AccessLevel'] = $charAccess;
$_SESSION['CorpAllow'] = $corpAccess;
$_SESSION['AllyAllow'] = $allyAccess;

printf("We made it here finally.<br>");



?>

<div class="table table-striped">
    
</div>