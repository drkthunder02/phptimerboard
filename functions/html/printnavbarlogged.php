<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function PrintNavBarLogged($character, $accessLevel) {
    $location = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/";
    $location = str_replace(array('/functions/html', '/functions/process'), '/timer', $location);
    
    if($accessLevel == 3 || $accessLevel == 4) {
        printf("<div class=\"navbar navbar-fixed-top\" role=\"navigation\">
                    <div class=\"navbar-header\">
                        <button class=\"navbar-toggle\" data-target=\".navbar-collapse\" data-toggle=\"collapse\" type=\"button\">
                            <span class=\"sr-only\">Toggle navigation</span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                        </button>
                    </div>
                    <div class=\"collapse navbar-collapse pull-left\">
                        <ul class=\"nav navbar-nav\">
                            <li><a href=\"" . $location . "index.php\">View Timers</a></li>
                            <li><a href=\"" . $location . "add.php\">Add Timer</a></li>
                            <li><a href=\"" . $location . "edit.php\">Edit Timer</a></li>
                            <li class=\"dropdown\"><a data-toggle=\"dropdown\" class=\"dropdown-toggle\">Admin<b class=\"caret\"></b></a>
                                <ul class=\"dropdown-menu\">
                                    <li><a href=\"" . $location . "addalliance.php\">Add Alliance</a></li>
                                    <li><a href=\"" . $location . "addcorporation.php\">Add Corporation</a></li>
                                    <li><a href=\"" . $location . "modifycharacter.php?part=\">Modify Character</a></li>
                                    <li><a href=\"" . $location . "removealliance.php\">Remove Alliance</a></li>
                                    <li><a href=\"" . $location . "removecorp.php\">Remove Corporation</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class=\"collapse navbar-collapse pull-right\">
                        <ul class=\"nav navbar-nav\">
                            <li><h3>" .  $character . " </h3></li>
                            <li><a href=\"" . $location . "logout.php\">Log Out</a></li>
                        </ul>
                    </div>
                </div>");
    } else if ($accessLevel == 2) {
        printf("<div class=\"navbar navbar-fixed-top\" role=\"navigation\">
                    <div class=\"navbar-header\">
                        <button class=\"navbar-toggle\" data-target=\".navbar-collapse\" data-toggle=\"collapse\" type=\"button\">
                            <span class=\"sr-only\">Toggle navigation</span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                        </button>
                    </div>
                    <div class=\"collapse navbar-collapse pull-left\">
                        <ul class=\"nav navbar-nav\">
                            <li><a href=\"" . $location . "index.php\">View Timers</a></li>
                            <li><a href=\"" . $location . "add.php\">Add Timer</a></li>
                            <li><a href=\"" . $location . "edit.php\">Edit Timer</a></li>
                        </ul>
                    </div>
                    <div class=\"collapse navbar-collapse pull-right\">
                        <ul class=\"nav navbar-nav\">
                            <li><h2>" .  $character . " </h2></li>
                            <li><a href=\"" . $location . "logout.php\">Log Out</a></li>
                        </ul>
                    </div>
                </div>");
    } else {
        printf("<div class=\"navbar navbar-fixed-top\" role=\"navigation\">
                    <div class=\"navbar-header\">
                        <button class=\"navbar-toggle\" data-target=\".navbar-collapse\" data-toggle=\"collapse\" type=\"button\">
                            <span class=\"sr-only\">Toggle navigation</span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                        </button>
                    </div>
                    <div class=\"collapse navbar-collapse pull-left\">
                        <ul class=\"nav navbar-nav\">
                            <li><a href=\"" . $location . "index.php\">View Timers</a></li>
                            <li><a href=\"" . $location . "add.php\">Add Timer</a></li>
                        </ul>
                    </div>
                    <div class=\"collapse navbar-collapse pull-right\">
                        <ul class=\"nav navbar-nav\">
                            <li><h2>" .  $character . " </h2></li>
                            <li><a href=\"" . $location . "logout.php\">Log Out</a></li>
                        </ul>
                    </div>
                </div>");
    }
    
    

    
}

?>
