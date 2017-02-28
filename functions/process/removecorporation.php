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

PrintHTMLHeaderLogged();
PrintNavBarLogged($character, $accessLevel);

$db = DBOpen();

//Get the corporation from the previous file
$corp = filter_input(POST, 'CorporationName');

//Update the access level to remove access from the corporation
$db->update('Corporations', array('Name' => $corp), array('AccessLevel' => 0));
//Cycle through characters of the corporation, and remove the characters of the corporation as well
$corpRemoval = $db->fetchRow('SELECT * FROM Corporations WHERE Name= :name', array('name' => $corp));
$characters = $db->fetchRowMany('SELECT * FROM Characters WHERE CorporationID= :id', array('id' => $corpRemoval['CorporationID']));
foreach($characters as $char) {
    $db->update('Characters', array('Name' => $char['Name']), array('AccessLevel' => 0));
}

//HTML for printout of all entities removed from access
printf("<div class=\"container\">");
printf("The Corporation removed from access list is " . $corpRemoval['Name'] . "<br>");
printf("The Characters remove from the accest list are: <br>");
foreach($characters as $char) {
    printf($char['Name'] . "<br>");
}
printf("</div>");

DBClose($db);

?>
