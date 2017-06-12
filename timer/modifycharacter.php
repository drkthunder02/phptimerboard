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

$session = new Custom\Sessions\session();

PrintHTMLHeaderLogged();
PrintNavBarLogged($_SESSION['Character'], $_SESSION['AccessLevel']);
printf("<br><br><br>");

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true && $_SESSION['AccessLevel'] < 3) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}
//Open the database connection
$db = DBOpen();

switch($_GET['part']) {
    case 2:
        $charAccessChange = filter_input(INPUT_POST, 'Characters');
        printf("<div class=\"container\">");
        printf("<form class=\"form-group\" method=\"POST\" action=\"modifycharacter.php?part=3\">");
        printf("<input type=\"hidden\" name=\"Character\" id=\"Character\" value=\"" . $charAccessChange . "\">");
        printf("<label for=\"NewAccessLevel\">Select Access Level</label><br>");
        printf("<select class=\"form-control\" id=\"NewAccessLevel\" name=\"NewAccessLevel\">");
        printf("<option>2</option><option>3</option><option>4</option>");
        printf("</select><br>");
        printf("<input class=\"form-control\" type=\"Submit\" value=\"Modify Character\">");
        
        printf("</form>");
        printf("</div>");
        break;
    case 3:
        $charAccessChange = filter_input(INPUT_POST, 'Character');
        $newAccessLevel = filter_input(INPUT_POST, 'NewAccessLevel');
        if($db->update('Characters', array('Name' => $charAccessChange), array('AccessLevel' => $newAccessLevel))) {
            printf("<div class=\"container\">");
            printf("Character: " . $charAccessChange . " updated to access level " . $newAccessLevel . "<br>");
            printf("</div>"); 
        } else {
            printf("<div class=\"container\">");
            printf("Character: " . $charAccessChange . "not found in the database.  Report the error to an admin.");
            printf("</div>");
        }
        break;
    default:
        //Get the characters from the database
        $characters = $db->fetchRowMany('SELECT * FROM Characters WHERE AccessLevel<4');


        //We have the list of all characters that we can modify.
        //Print out a list of characters in a selector box to allow the user to select the character to be modified
        printf("<div class=\"container\">
                    <form class=\"form-group\" method=\"POST\" action=\"modifycharacter.php?part=2\">
                        <label for=\"Characters\">Characters:</label>
                        <select class=\"form-control\" id=\"Characters\" name=\"Characters\">");
        foreach($characters as $char) {
            printf("<option value=\"" . $char['Name'] . "\">");
            printf($char['Name']);
            printf(" Access Level: ");
            printf($char['AccessLevel']);
            printf("</option>");
        }
        printf("<option></option>
                </select>");
        printf("<br>");
        printf("<div class=\"container col-md-4\">");
        printf("<input class=\"form-control\" type=\"Submit\" value=\"Choose Character to Modify\">");
        printf("</div>");
        printf("</form>
        </div>");
        break;
}

DBClose($db);

PrintHTMLFooterLogged();

?>
            