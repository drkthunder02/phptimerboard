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
if(isset($_POST['AllianceName'])) {
    $allianceName = filter_input(POST, 'AllianceName');
} else {
    $allianceName = NULL;
}
//Get the Alliance ID from the form
if(isset($_POST['AllianceId'])) {
    $allianceId = filter_input(POST, 'AllianceId');
} else {
    $allianceId = NULL;
}

if($allianceId != NULL) {
    //Contact ESI for the alliance ID to name to store the results in the database
    //With the corporation id in hand, let's find the alliance id
    $url = 'https://esi.tech.ccp.is/latest/alliances/' . $allianceId . '/?datasource=tranquility';
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
        printf("Unable to verify alliance in the ESI Calls.  Please try again later.<br>");
        die();
    }
    $alliance = json_decode($result, true);
    //See if the alliance is found in the access list already
    $found = $db->fetchRow('SELECT * FROM Alliances WHERE AllianceID= :id', array('id' => $allianceId));
    if($found == false) {
        $db->insert('Alliances', array(
            'AllianceID' => $allianceId,
            'Name' => $alliance['alliance_name'],
            'AccessLevel' => 1
        ));
    }
    
} else if ($allianceName != NULL) {
    //Get the alliance name from the database's list from esi
    $row = $db->fetchRow('SELECT * FROM AllianceNames WHERE Name= :name', array('name' => $allianceName));
    if($row == false) {
        PrintHTMLHeaderLogged();
        PrintNavBarLogged($character, $accessLevel);
        printf("Unable to find the name in the database.  Please try again but enter the alliance id instead.<br>");
        PrintHTMLFooterLogged();
    }
    //See if the name is already in the access list
    $found = $db->fetchRow('SELECT * FROM Alliances WHERE AllianceID= :id', array('id' => $row['AllianceID']));
    //If the alliance is not found in the access list, then add it otherwise continue
    if($found == false) {
        $db->insert('Alliances', array(
            'AllianceID' => $row['AllianceID'],
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
