<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function PrintNavBarLogged($character, $accessLevel) {
    if($accessLevel == 3 || $accessLevel == 4) {
        printf("<div class=\"navbar navbar-inverse navbar-fixed-top\" style=\"height: 60px;\" role=\"navigation\">
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
                            <li><a href=\"index.php\">View Timers</a></li>
                            <li><a href=\"add.php\">Add Timer</a></li>
                            <li><a href=\"edit.php\">Edit Timer</a></li>
                            <li><a href=\"remove.php\">Remove Timer</a></li>
                            <li class=\"dropdown\"><a data-toggle=\"dropdown\" class=\"dropdown-toggle\">Admin<b class=\"caret\"></b></a>
                                <ul class=\"dropdown-menu\">
                                    <li><a href=\"addalliance.php\">Add Alliance</a></li>
                                    <li><a href=\"addcorporation.php\">Add Corporation</a></li>
                                    <li><a href=\"modifycharacter.php\">Modify Character</a></li>
                                    <li><a href=\"removealliance.php\">Remove Alliance</a></li>
                                    <li><a href=\"removecorp.php\">Remove Corporation</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class=\"collapse navbar-collapse pull-right\">
                        <ul class=\"nav navbar-nav\">
                            <li><h2>" .  $character . " </h2></li>
                            <li><a href=\"logout.php\">Log Out</a></li>
                        </ul>
                    </div>
                </div>");
    } else if ($accessLevel == 2) {
        printf("<div class=\"navbar navbar-inverse navbar-fixed-top\" style=\"height: 60px;\" role=\"navigation\">
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
                            <li><a href=\"index.php\">View Timers</a></li>
                            <li><a href=\"add.php\">Add Timer</a></li>
                            <li><a href=\"edit.php\">Edit Timer</a></li>
                            <li><a href=\"remove.php\">Remove Timer</a></li>
                        </ul>
                    </div>
                    <div class=\"collapse navbar-collapse pull-right\">
                        <ul class=\"nav navbar-nav\">
                            <li><h2>" .  $character . " </h2></li>
                            <li><a href=\"logout.php\">Log Out</a></li>
                        </ul>
                    </div>
                </div>");
    } else {
        printf("<div class=\"navbar navbar-inverse navbar-fixed-top\" style=\"height: 60px;\" role=\"navigation\">
                    <div class=\"navbar-header\">
                        <button class=\"navbar-toggle\" data-target=\".navbar-collapse\" data-toggle=\"collapse\" type=\"button\">
                            <span class=\"sr-only\">Toggle navigation</span>
                            <span class=\"icon-bar\"></span>
                            <span class=\"icon-bar\"></span>
                        </button>
                    </div>
                    <div class=\"collapse navbar-collapse pull-left\">
                        <ul class=\"nav navbar-nav\">
                            <li><a href=\"index.php\">View Timers</a></li>
                            <li><a href=\"add.php\">Add Timer</a></li>
                        </ul>
                    </div>
                    <div class=\"collapse navbar-collapse pull-right\">
                        <ul class=\"nav navbar-nav\">
                            <li><h2>" .  $character . " </h2></li>
                            <li><a href=\"logout.php\">Log Out</a></li>
                        </ul>
                    </div>
                </div>");
    }
    
    

    
}

?>
