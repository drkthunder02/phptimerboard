<?php

/* 
 * ========== * EVE ONLINE TEAMSPEAK V2 BY Lowjack Tzetsu * ==========
 * ========== * EVE ONLINE TEAMSPEAK V2 BASED ON MJ MAVERICK * ============ 
 */

// 1 - https://login.eveonline.com/oauth/authorize
// 2 - https://login.eveonline.com/oauth/authorize/?response_type=code&redirect_uri=https%3A%2F%2F3rdpartysite.com%2Fcallback&client_id=3rdpartyClientId&scope=characterContactsRead%20characterContactsWrite&state=uniquestate123
// 3 - Verify the Authorization Code and retrieve the access token and refresh token
// 4 - Store the access token and refresh token in the database

// PHP debug mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);
//Get the required files from the function registry
require_once __DIR__.'/functions/registry.php';

//Start a session
$session = new \Custom\Sessions\session();
$config = parse_ini_file(__DIR__.'/functions/configuration/config.ini');

$clientid = $config['clientid'];
$secretkey = $config['secretkey'];
$useragent = $config['useragent'];

$db = DBOpen();

//If the state is not set then set it to NULL
if(!isset($_SESSION['state'])) {
    $_SESSION['state'] = uniqid();
}

PrintHTMLHeader();

switch($_REQUEST['action']) {
    //If we are the start of the SSO process, then print a box to login into EVE via the SSO
    case 'new':
        //https://login.eveonline.com/oauth/authorize/?response_type=code&redirect_uri=https%3A%2F%2F3rdpartysite.com%2Fcallback&client_id=3rdpartyClientId&scope=characterContactsRead%20characterContactsWrite&state=uniquestate123
        printf("<div class=\"container\">");
        printf("<div class=\"jumbotron\">");
        printf("<p><h1>PHP Timerboard for EVE Online</h1></p>");
        printf("<br>");
        printf("<p><h3>Please login via EVE Online SSO to be verified for access.</h3></p>");
        printf("<br>");
        printf("<p align=\"center\">");
        printf("<a href=\"https://login.eveonline.com/oauth/authorize/?response_type=code&redirect_uri=" . 
                urldecode(GetSSOCallbackURL()) . "&client_id=" . 
                $clientid . "&state=" . $_SESSION['state'] . "\">");
        printf("<img src=\"images/EVE_SSO_Login_Buttons_Large_Black.png\">");
        printf("</a>");
        printf("</p>");
        printf("</div>");
        printf("</div>");
        break;
    //If we got the redirect back to the site, then verify the tokens, and store them
    case 'eveonlinecallback':
        //Verify the state
        if($_REQUEST['state'] != $_SESSION['state']) {
            printf("<div class=\"container\">");
            printf("Invalid State!  You will have to start again.");
            printf("<a href=\"" . $_SERVER['PHP_SELF'] . "?action=new\">Start again!</a>");
            printf("</div>");
            unset($_SESSION['state']);
            die();
        }
        //Clear the state value.
        unset($_SESSION['state']);
        //Do the initial check.
        $url = 'https://login.eveonline.com/oauth/token';
        $header = 'Authorization: Basic '.base64_encode($clientid.':'.$secretkey);
        $fields_string='';
        $fields=array(
                    'grant_type' => 'authorization_code',
                    'code' => $_GET['code']
                );
        foreach ($fields as $key => $value) {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        $result = curl_exec($ch);
        //Get the resultant data from the curl call
        $data = json_decode($result, true);
        //With the access token and refresh token make the cURL call to get the characterID
        $url = 'https://login.eveonline.com/oauth/verify';
        $header='Authorization: Bearer ' . $data['access_token']; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //Get the result from the curl call
        $result = curl_exec($ch);
        if ($result===false) {
            printf("Error with talking to eveonline servers.<br>");
        }
        //Close the curl channel
        curl_close($ch);
        //Get the resultant data from the curl call
        $data = json_decode($result);
        $characterID = $data->CharacterID;
        //With the character ID in hand, let's find the character's corporation and alliance if any
        $url = 'https://esi.tech.ccp.is/latest/characters/' . $characterID . '/?datasource=tranquility';
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
            printf("Unable to verify character in the ESI Calls.  Please try again later.<br>");
            die();
        }
        $character = json_decode($result, true);
        //With the corporation id in hand, let's find the alliance id
        $url = 'https://esi.tech.ccp.is/latest/corporations/' . $character['corporation_id'] . '/?datasource=tranquility';
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
            printf("Unable to verify character in the ESI Calls.  Please try again later.<br>");
            die();
        }
        $corporation = json_decode($result, true);
        
        $installed = $db->fetchColumn('SELECT Installed FROM Install');
        if($installed == 0) {
            Install($db, $characterID, $character, $corporation, $useragent);
            die();
        }
        
        SSOSuccess($character, $corporation, $characterID);
        
        break;
    //If we don't know what state we are in then go back to the beginning
    default:
        RedirectToNew();
        break;
}

DBClose($db);

printf("</body>");
printf("</html>");

