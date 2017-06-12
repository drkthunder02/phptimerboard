<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// PHP debug mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//Get the required files from the function registry
require_once __DIR__.'/../functions/registry.php';

//Start a session
$session = new \Custom\Sessions\session();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true AND $_SESSION['AccessLevel'] < 3 ) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

PrintHTMLHeaderLogged();
PrintNavBarLogged($_SESSION['Character'], $_SESSION['AccessLevel']);
printf("<br><br>");

//Add an alliance to the white list
printf("<div class=\"container\">
            <h3>Enter either the alliance name or alliance id of the alliance to add to the ability to login.</h3><br>
            <form class=\"form-group\" action=\"../functions/process/addalliance.php\" method=\"POST\">
                <div class=\"form-group\">
                    <label for=\"AllianceName\">Alliance Name:</label>
                    <input class=\"form-control\" type=\"text\" name=\"AllianceName\" id=\"AllianceName\">
                </div>
                <button class=\"btn btn-default\" type=\"submit\">Add Alliance</button>
            </form>
        </div>");

PrintHTMLFooterLogged();

?>
