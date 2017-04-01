<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// PHP debug mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/../functions/registry.php';

//Start the session
$session = new \Custom\Sessions\session();
//Open the database connection
$db = DBOpen();

print("<html>");
PrintHTMLHeaderLogged();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}
//Print the navbar
PrintNavBarLogged($_SESSION['Character'], $_SESSION['AccessLevel']);

//Print out the timers that are going on currently since we have printed out the navigation bar at the to"
$currentTime = time();
$timers = $db->fetchRowMany('SELECT * FROM Timers WHERE EVETime >= :now', array('now' => $currentTime));

//Print out the table header and the start of the body tag
printf("<br><br><br>");

printf("<div class=\"container\">");
printf("<form action=\"/functions/html/printedittimer.php\" method=\"POST\">");
printf("<table class=\"table-reponsive\">
            <thead>
                <tr>
                    <th class=\"col-md-1\">Type</th>
                    <th class=\"col-md-1\">Stage</th>
                    <th class=\"col-md-2\">Location</th>
                    <th class=\"col-md-1\">Owner</th>
                    <th class=\"col-md-1\">EVE Time</th>
                    <th class=\"col-md-1\">Remaining</th>
                    <th class=\"col-md-3\">Notes</th>
                    <th class=\"col-md-1\">User</th>
                    <th class=\"col-md-1\">Modify</th>
                </tr>
            </thead>");

if($timers != NULL) {
    printf("<tbody>");
    foreach($timers as $timer) {
        $now = time();
        $remaining = $timer['EVETime'] - $now;
        $remaining = ConvertTime($remaining);
        $eveTime = date("Y-m-d H:i:s", $timer['EVETime']);
        
        if($timer['Type'] == 'Defensive') {
            printf("<tr class=\"warning\">");
        } else if ($timer['Type'] == 'Offensive') {
            printf("<tr class=\"danger\">");
        } else if ($timer['Type'] == 'Structure') {
            printf("<tr class=\"info\">");
        }
        
        $location = $timer['Region'] . " - " . $timer['System'] . " - " . $timer['Planet'] . " - " . $timer['Moon'];
        
        printf("<td class=\"col-md-1\">" . $timer['Type'] . "</td>");
        printf("<td class=\"col-md-1\">" . $timer['Stage'] . "</td>");
        printf("<td class=\"col-md-3\">" . $location . "</td>");
        printf("<td class=\"col-md-1\">" . $timer['Owner'] . "</td>");
        printf("<td class=\"col-md-2\">" . $eveTime . "</td>");
        printf("<td class=\"col-md-1\">" . $remaining . "</td>");
        printf("<td class=\"col-md-2\">" . $timer['Notes'] . "</td>");
        printf("<td class=\"col-md-1\">" . $timer['User'] . "</td>");
        printf("<td class=\"col-md-1\"><input type=\"radio\" value=\"" . $timer['id'] . " name=\"TimerID\"></td>");
        printf("</tr>");
    }  
    printf("</tbody>");
} else {
    printf("<tbody>");
    printf("<tr>");
    printf("<td class=\"col-md-1\">N/A</td>");
    printf("<td class=\"col-md-1\">N/A</td>");
    printf("<td class=\"col-md-3\">N/A</td>");
    printf("<td class=\"col-md-1\">N/A</td>");
    printf("<td class=\"col-md-2\">N/A</td>");
    printf("<td class=\"col-md-1\">N/A</td>");
    printf("<td class=\"col-md-2\">N/A</td>");
    printf("<td class=\"col-md-1\">N/A</td>");
    printf("</tr>");
    printf("</tbody>");
}

printf("</table>");
printf("<br>");
printf("<div class=\"container\">");
printf("<input class=\"col-md-offset-10\" type=\"Submit\" value=\"Modify Selected Timer\">");
printf("</div>");
printf("</form>");

PrintHTMLFooterLogged();
printf("</html>");

//Close the database connection
DBClose($db);