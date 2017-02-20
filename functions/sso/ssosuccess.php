<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function SSOSuccess($char, $corp, $charID) {
    $db = DBOpen();
    
    //Search for the character in the database to see if its the first time loggin in
    $first = $db->fetchRow('SELECT * FROM Characters WHERE CharacterID= :id', array('id' => $charID));
    if($first === false) {
        $db->insert('Characters', array(
            'CharacterID' => $charID,
            'Name' => $char['name'],
            'Corporation' => $char['corporation_id'],
            'AccessLevel' => 1
        ));
    }
    
    
    $charAccess = $db->fetchColumn('SELECT AccessLevel FROM Characters WHERE CharacterID= :id', array('id' => $charID));
    $corpAccess = $db->fetchColumn('SELECT AccessLevel FROM Corporations WHERE CorporationID= :id', array('id' => $char['corporation_id']));
    $allyAccess = $db->fetchColumn('SELECT AccessLevel FROM Alliances WHERE AllianceID= :id', array('id' => $corp['alliance_id']));
    
    if($corpAccess == 0 OR $allyAccess == 0) {
        printf("Sorry but your alliance or corporation is not allowed to login.<br>");
        die();
    }
    
    
    $_SESSION['logged'] = true;
    $_SESSION['Character'] = $char['name'];
    $_SESSION['AccessLevel'] = $charAccess;
    $_SESSION['CorpAllow'] = $corpAccess;
    $_SESSION['AllyAllow'] = $allyAccess;
    
    
    
    
    
    
    
    
    DBClose($db);
}

?>