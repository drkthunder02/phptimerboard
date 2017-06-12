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

$db = DBOpen();

$corporations = $db->fetchRowMany('SELECT * FROM Corporations WHERE AccessLevel>0');

printf("<div class-\"container\">");
printf("<div class=\"jumbotron col-md-4 col-md-offset-4\">");
printf("<form class=\"form-group\" action=\"/../process/removecorporation.php\" method=\"POST\">");
printf("<div class=\"form-group\">");
printf("<label for=\"CorporationName\">Corporation Name: </label>");
printf("<select class=\"form-control\" id=\"CorporationName\">");
foreach($corporations as $corp) {
    printf("<option value=\"" . $corp['Name'] . ">" . $corp['Name'] . "</option>");
}
printf("</select>");
printf("</div>");
printf("</form>");
printf("</div>");

DBClose($db);

PrintHTMLFooterLogged();

?>
