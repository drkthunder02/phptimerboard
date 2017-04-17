<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// PHP debug mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

function SSOSuccess($char, $corp, $charID) {
    $db = DBOpen();
    
    $corpAccess = $db->fetchColumn('SELECT AccessLevel FROM Corporations WHERE CorporationID= :id', array('id' => $char['corporation_id']));
    $corpAccess = $corpAccess * 1;
    $allyAccess = $db->fetchColumn('SELECT AccessLevel FROM Alliances WHERE AllianceID= :id', array('id' => $corp['alliance_id']));
    $allyAccess = $allyAccess * 1;
    
    //Search for the character in the database to see if its the first time loggin in
    $first = $db->fetchRow('SELECT * FROM Characters WHERE CharacterID= :id', array('id' => $charID));
    printf("<br>");
    //Need to check if corporation or alliance has access
    if($first == false) {
        //Check if alliance is found and the access level
        if($corpAccess > 0 || $allyAccess > 0) {
           $db->insert('Characters', array(
                'CharacterID' => $charID,
                'Name' => $char['name'],
                'CorporationID' => $char['corporation_id'],
                'AccessLevel' => 1
            ));
        }
    }
    
    //Access Levels:
    //0 - Not Allowed at all
    //1 - Read & Write Timers
    //2 - Read, Write, & Edit Timers
    //3 - Read & Write Timers, Administrator
    //4 - Super Admin
    //Corporations should not have access level above 1
    //Characters can have higher than 1 access level.
    
    $charAccess = $db->fetchColumn('SELECT AccessLevel FROM Characters WHERE CharacterID= :id', array('id' => $charID));
    
    if($corpAccess == 0 && $allyAccess == 0) {
        printf("Sorry but your alliance or corporation is not allowed to login.<br>");
        printf("Alliance did not have access.  Corporation did not have access.<br>");
        die();
    }
    if($charAccess == 0) {
        printf("Sorry but your character do not have access to this timer board.<br>");
        die();
    }
    
    
    
    $_SESSION['logged'] = true;
    $_SESSION['Character'] = $char['name'];
    $_SESSION['CharacterID'] = $charID;
    $_SESSION['AccessLevel'] = $charAccess;
    $_SESSION['CorpAllow'] = $corpAccess;
    $_SESSION['AllyAllow'] = $allyAccess;

    DBClose($db);
    
    print("Logging into site now.<br>");
    sleep(3);
    //Go to the main site for timers in the timerboard
    $location = 'http://' . $_SERVER['HTTP_HOST'];
    $location = $location . dirname($_SERVER['PHP_SELF']) . '/timer/index.php';
    header("Location: $location");
}

?>