<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../functions/registry.php';

//Start the session
$session = new \Custom\Sessions\session();

PrintHTMLHeaderLogged();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}
//Print the navbar
PrintNavBarLogged($_SESSION['Character'], $_SESSION['AccessLevel']);

$currentTime = time();

//Print out the timers that are going on currently since we have printed out the navigation bar at the to"
$timers = $db->fetchRowMany('SELECT * FROM Timers WHERE EVETime >= :now', array('now' => $currentTime));
//Print out the table header and the start of the body tag
printf("<div class=\"table table-striped\">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Stage</th>
                    <th>Region</th>
                    <th>System</th>
                    <th>Planet</th>
                    <th>Moon</th>
                    <th>Owner</th>
                    <th>EVE Time</th>
                    <th>Remaining</th>
                    <th>Notes</th>
                    <th>User</th>            
                </tr>
            </thead><tbody>");
foreach($timers as $timer) {
    $now = time();
    $remaining = $timer['EVETime'] - $now;
    $remaining = date("Y-m-d H:i:s", $remaining);
    $eveTime = date("Y-m-d H:i:s", $timer['EVETime']);
    
    printf("<tr>");
    printf("<td>" . $timer['Type'] . "</td>");
    printf("<td>" . $timer['Stage'] . "</td>");
    printf("<td>" . $timer['Region'] . "</td>");
    printf("<td>" . $timer['System'] . "</td>");
    printf("<td>" . $timer['Planet'] . "</td>");
    printf("<td>" . $timer['Moon'] . "</td>");
    printf("<td>" . $timer['Owner'] . "</td>");
    printf("<td>" . $eveTime . "</td>");
    printf("<td>" . $remaining . "</td>");
    printf("<td>" . $timer['Notes'] . "</td>");
    printf("<td>" . $timer['User'] . "</td>");
    printf("</tr>");
}
printf("</tbody></div>");

PrintHTMLFooterLogged();

?>
