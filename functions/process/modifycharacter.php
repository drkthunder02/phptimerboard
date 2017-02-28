<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once __DIR__.'/../functions/registry.php';

$session = new Custom\Sessions\session();

PrintHTMLHeaderLogged();
PrintNavBarLogged($character, $accessLevel);

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true && $_SESSION['AccessLevel'] < 3) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

$db = DBOpen();

switch($_GET['part']) {
    case 2:
        $charAccessChange = filter_input(POST, 'Characters');
        printf("<div class=\"container\">");
        printf("<form class=\"form-group\" method=\"POST\" action=\"modifycharacter.php?part=3\">");
        printf("<label for=\"NewAccessLevel\">Select Access Level</label>");
        printf("<select class=\"form-group\" id=\"NewAccessLevel\" name=\"NewAccessLevel\">");
        printf("<option>2</option><option>3</option><option>4</option>");
        printf("</select>");
        printf("<input type=\"hidden\" name=\"Character\" value=\"" . $charAccessChange . ">");
        printf("</form>");
        printf("</div>");
        break;
    case 3:
        $charAccessChange = filter_input(POST, 'Character');
        $newAccessLevel = filter_input(POST, 'NewAccessLevel');
        $db->update('Characters', array('Name' => $charAccessChange), array('AccessLevel' => $newAccessLevel));
        printf("<div class=\"container\">");
        printf("Character: " . $charAccessChange . " updated to access level " . $newAccessLevel . "<br>");
        printf("</div>");
        break;
    default:
        //Get the characters from the database
        $characters = $db->fetchRowMany('SELECT * FROM Characters WHERE AccessLevel<4');


        //We have the list of all characters that we can modify.
        //Print out a list of characters in a selector box to allow the user to select the character to be modified
        printf("<div class=\"container\">
                    <form class=\"form-group\" method=\"POST\" action=\"modifycharacter.php?part=2\">
                        <label for=\"Characters\">Characters:</label>
                        <select class=\"form-group\" id=\"Characters\" name=\"Characters\">");
        foreach($characters as $char) {
            printf("<option>");
            printf($char['Name']);
            printf(" Access Level: ");
            printf($char['Access Level']);
            printf("</option>");
        }
        printf("<option></option>
                </select>
            </form>
        </div>");
        break;
}

DBClose($db);

?>
            