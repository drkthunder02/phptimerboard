<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Get the required files from the function registry
require_once __DIR__.'/functions/registry.php';

//Start a session
$session = new \Custom\Sessions\session();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true AND $_SESSION['AccessLevel'] < 3 ) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

$list = array();
$listNum = 0;

//Get the input from the form
$allyRemove = filter_input(POST, 'AllianceName');
//Open the database connection
$db = DBOpen();
//Get the alliance to be removed from the database
$allyRemDb = $db->fetchRow('SELECT * FROM Alliances WHERE Name= :name', array('name' => $allyRemove));
//Set the access level for the alliance to be removed 
$db->update('Alliances', array('AllianceID' => $allyRemDb['AllianceID']), array('AccessLevel' => 0));
//Get the entire list of corporations
$allCorps = $db->fetchRowMany('SELECT * FROM Corporations WHERE AllianceID= :id', array('id' => $allyRemDb['AllianceID']));
foreach($allCorps as $corp) {
    //Update the corporation to AccessLevel 0
    $db->update('Corporations', array('CorporationID' => $corp['CorporationID']), array('AccessLevel' => 0));
    //Remove the characters involved with the corporation from the access list
    $allChars = $db->fetchRowMany('SELECT * FROM Characters WHERE CorporationID= :id', array('id' => $corp['CorporationID']));
    foreach($allChars as $char) {
        $db->update('Characters', array('CharacterID' => $char['CharacterID']), array('AccessLevel' => 0));
        $list[$listNum] = $char['Name'];
        $listNum++;
    }
}

PrintHTMLHeaderLogged();
PrintNavBarLogged($_SESSION['Character'], $_SESSION['AccessLevel']);

printf("<div class=\"container\">");
printf("Alliance Name: " . $allyRemove . " removed from the access list.<br>");
foreach($allCorps as $corp) {
    $allChars = $db->fetchRowMany('SELECT * FROM Characters WHERE CorporationID= :id', array('id' => $corp['CorporationID']));
    printf("Corporation Name: " . $corp['Name'] . " was removed from the access list.<br>");
    printf("Characters Removed:<br>");
    foreach($allChars as $char) {
        printf($char['Name'] . "<br>");
    }
}
printf("</div>");

PrintHTMLFooterLogged();

?>
