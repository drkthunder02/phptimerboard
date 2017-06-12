<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// PHP debug mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/../registry.php';

$session = new Custom\Sessions\session();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true && $_SESSION['AccessLevel'] < 3) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

//Client ID and Secret Key for using ESI to find alliance information to be adding
$config = parse_ini_file('../configuration/config.ini');
$useragent = $config['useragent'];

$db = DBOpen();


//Get the Alliance Name from the form
if(isset($_POST['CorporationName'])) {
    $corporationName = filter_input(POST, 'CorporationName');
} else {
    $corporationName = NULL;
}

$url = 'https://esi.tech.ccp.is/latest/search/?categories=corporatione&datasource=tranquility&language=en-us&search=' . $corporationName . '&strict=false';
//Start the curl request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
$result = curl_exec($ch);
//Check for curl error
if(!curl_error($ch)) {
    $data = json_deocde($result, true);
    $corporationId = $data['corporation'][0];
} else {
    $corporationId = null;
}

if($corporationId != NULL) {
    //Contact ESI for the alliance ID to name to store the results in the database
    //With the corporation id in hand, let's find the alliance id
    $url = 'https://esi.tech.ccp.is/latest/corporations/' . $corporationId . '/?datasource=tranquility';
    $header = 'Accept: application/json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    $result = curl_exec($ch);
    if(curl_error($ch)) {
        printf("Unable to verify corporation in the ESI Calls.  Please try again later.<br>");
        die();
    }
    $corporation = json_decode($result, true);
    //See if the corporation is found in the access list already
    $found = $db->fetchRow('SELECT * FROM Corporations WHERE CorporationID= :id', array('id' => $corporationId));
    if($found == false) {
        $db->insert('Corporations', array(
            'CorporationID' => $corporationId,
            'Name' => $corporation['corporation_name'],
            'AccessLevel' => 1
        ));
    }
    
}

DBClose($db);

//Go to the main site for timers in the timerboard
$location = 'http://' . $_SERVER['HTTP_HOST'];
$location = $location . dirname($_SERVER['PHP_SELF']) . '/timer/index.php';
header("Location: $location");

?>
