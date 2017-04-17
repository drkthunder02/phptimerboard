<?php

function Install($db, $characterID, $character, $corporation, $useragent) {
    //Set the character and the character's corporation as the default admin for the site.
    $db->insert('Characters', array(
        'CharacterID' => $characterID,
        'Name' => $character['name'],
        'CorporationID' => $character['corporation_id'],
        'AccessLevel' => 4
    ));
    
     //With the corporation id in hand, let's find the alliance id
    if(isset($corporation['alliance_id'])) {
        $url = 'https://esi.tech.ccp.is/latest/alliances/' . $corporation['alliance_id'] . '/?datasource=tranquility';
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
            printf("Unable to verify alliance for installation in the ESI Calls.  Please try again later.<br>");
            die();
        }
        $alliance = json_decode($result, true);
        
        //Get the corporations in the alliance to be added to the database as normal users
        $url = 'https://esi.tech.ccp.is/latest/alliances/' . $corporation['alliance_id'] . '/corporations/?datasource=tranquility';
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
            printf("Unable to verify corporations for installation in the ESI Calls.  Please try again later.<br>");
            die();
        }
        $corporationIds = json_decode($result, true);
        //Get the corporation information for each corporation in the alliance, then insert them into the database
        foreach($corporationIds as $id) {
            $url = 'https://esi.tech.ccp.is/latest/corporations/' . $id . '/?datasource=tranquility';
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
            $corp = json_decode($result, true);
            $db->insert('Corporations', array(
                'CorporationID' => $id,
                'Name' => $corp['corporation_name'],
                'AllianceID' => $corporation['alliance_id'],
                'AccessLevel' => 1
            ));
        }  
    } else {
        $db->insert('Corporations', array(
            'CorporationID' => $character['corporation_id'],
            'Name' => $corporation['corporation_name'],
            'AccessLevel' => 1
        ));
    }
    
    printf("Added Character: " . $character['name'] . "<br>");
    printf("Added Corporation: " . $corporation['corporation_name'] . "<br>");
    if($alliance['alliance_name']) {
        printf("Added Alliance: " . $alliance['alliance_name'] . "<br>");
    }
    
    $db->update('Install', array('Installed' => 0), array('Installed' => 1));
    
    printf("Pleaes navigate back to main page to relog.");            
}

?>
