<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../registry.php';

$session = new Custom\Sessions\session();

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
    
} else if ($corporationName != NULL) {
    //Get the corporation name from the database's list from esi
    $row = $db->fetchRow('SELECT * FROM CorporationNames WHERE Name= :name', array('name' => $corporationName));
    if($row == false) {
        PrintHTMLHeaderLogged();
        PrintNavBarLogged($character, $accessLevel);
        printf("Unable to find the name in the database.  Please try again but enter the corporation id instead.<br>");
        PrintHTMLFooterLogged();
    }
    //See if the name is already in the access list
    $found = $db->fetchRow('SELECT * FROM Corporations WHERE CorporationID= :id', array('id' => $row['CorporationID']));
    //If the corporation is not found in the access list, then add it otherwise continue
    if($found == false) {
        $db->insert('Corporations', array(
            'CorporationID' => $row['CorporationID'],
            'Name' => $row['Name'],
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
