<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// PHP debug mode
ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once __DIR__.'/../../functions/registry.php';

//Start the session
$session = new \Custom\Sessions\session();
//If not allowed to access the page, delete all session variables, and exit
if($_SESSION['logged'] != true) {
    printf("You are not allowed access to this page.<br>");
    unset($_SESSION);
    die();
}

//Get the id being passed from the previous page
if(isset($_POST['TimerID'])) {
    $timerId = filter_input(INPUT_POST, "TimerID", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
} else {
    $timerId = NULL;
    $location = 'http://' . $_SERVER['HTTP_HOST'];
    $location = $location . dirname($_SERVER['PHP_SELF']) . '/../../timer/index.php';
    header("Location: $location");
    die();
}

//Open the database connection
$db = DBOpen();
//Print the HTML Header section
print("<html>");
PrintHTMLHeaderLogged();
//Print the navbar
PrintNavBarLogged($_SESSION['Character'], $_SESSION['AccessLevel']);

//Print out the timers that are going on currently since we have printed out the navigation bar at the to"
$timer = $db->fetchRow('SELECT * FROM Timers WHERE id= :id', array('id' => $timerId));
//Convert the time back to regular format instead of integer
$time = date("Y-m-d H:i:s", $timer['EVETime']);

//Print out the table header and the start of the body tag
printf("<br><br><br>");

printf("<div class=\"container\">
            <form class=\"form-group\" action=\"../../functions/process/edittimer.php\" method=\"POST\">");
        printf("<input class=\"form-control\" type=\"hidden\" name=\"id\" id=\"id\" value=\"" . $timer['id'] . "\">");
if($timer['Type'] == "Offensive") {
        printf("<label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Offensive\" checked>Offensive</label>
                <label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Defensive\">Defense</label>
                <label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Fuel\">Fuel</label>");
} else if($timer['Type'] == "Defensive") {
        printf("<label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Offensive\">Offensive</label>
                <label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Defensive\" checked>Defense</label>
                <label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Fuel\">Fuel</label>");
} else if($timer['Type'] == "Fuel") {
        printf("<label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Offensive\">Offensive</label>
                <label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Defensive\">Defensive</label>
                <label class=\"radio-inline\"><input type=\"radio\" name=\"Type\" value=\"Fuel\" checked>Fuel</label>");
}  
            printf("<div class=\"form-group\">
                    <label for=\"Stage\">Stage:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Stage\" id=\"Stage\" placeholder=\"" . $timer['Stage'] . "\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Region\">Region:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Region\" id=\"Region\" placeholder=\"" . $timer['Region'] . "\">
                </div>
                <div class=\"form-group\">
                    <label for=\"System\">System:</label>
                    <input class=\"form-control\" type=\"text\" name=\"System\" id=\"System\" placeholder=\"" . $timer['System'] . "\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Planet\">Planet:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Planet\" id=\"Planet\" placeholder=\"" . $timer['Planet'] . "\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Moon\">Moon:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Moon\" id=\"Moon\" placeholder=\"" . $timer['Moon'] . "\">
                </div>
                <div class=\"form-group\">
                    <label for=\"Notes\">Notes:</label>
                    <input class=\"form-control\" type=\"text\" name=\"Notes\" id=\"Notes\" placeholder=\"" . $timer['Notes'] . "\">
                </div>
                <div class=\"form-group\"><br>
                    <input class=\"form-control\" type=\"Submit\" value=\"Edit Timer\">
                </div>
            </form>
        </div>");

PrintHTMLFooterLogged();

//Close the database connection
DBClose($db);

?>
