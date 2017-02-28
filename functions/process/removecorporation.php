<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../registry.php';

$session = new Custom\Sessions\session();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true && $_SESSION['AccessLevel'] < 3) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

//Client ID and Secret Key for using ESI to find alliance information to be adding
$clientid = '4d87d41740c24eac96f8b9e4b77ceb35';
$secretkey = 'xNe3zYNHrQszmy5GfVk6AKbzUbwVFDgicd7zqrF7';
$useragent = 'PHP Timerboard';

$db = DBOpen();


//Get the Alliance Name from the form
if(isset($_POST['CorporationName'])) {
    $corporationName = filter_input(POST, 'CorporationName');
} else {
    $corporationName = NULL;
}
//Get the Alliance ID from the form
if(isset($_POST['CorporationId'])) {
    $corporationId = filter_input(POST, 'CorporationId');
} else {
    $corporationId = NULL;
}