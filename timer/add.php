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

//Start a session
$session = new \Custom\Sessions\session();

//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

PrintHTMLHeaderLogged();
PrintNavBarLogged($_SESSION['Character'], $_SESSION['AccessLevel']);

//Add timer form
printf("<div class=\"container\">
            <form class=\"form-group\" action=\"/../process/addtimer.php\" method=\"POST\">
                <label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"Type\" value=\"Offensive\">Offensive</label>
                <label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"Type\" value=\"Defensive\">Defense</label>
                <label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"Type\" value=\"Fuel\">Fuel</label>
                <div class=\"form-group\">
                    <label for=\"Stage\">Stage:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Stage\" id=\"Stage\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Region\">Region:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Region\" id=\"Region\">
                </div>
                <div class=\"form-group\">
                    <label for=\"System\">System:</label>
                    <input class=\"form-control\" type=\"text\" name=\"System\" id=\"System\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Planet\">Planet:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Planet\" id=\"Planet\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Moon\">Moon:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Moon\" id=\"Moon\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Owner\">Owner:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Owner\" id=\"Owner\">
                </div>
                <div class=\"form-group\">
                    <label for=\"EVE_Time\">EVE Time:</label>
                    <input class=\"form-control\" type=\"text\" name=\"EVE_Time\" id=\"EVE_Time\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Notes\">Notes:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Notes\" id=\"Notes\">
                    <input class=\"form-control\" type=\"hidden\" name=\"User\" id=\"User\">
                </div>    
            </form>
        </div>");

PrintHTMLFooterLogged();

?>

