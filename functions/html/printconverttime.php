<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function ConvertTime($time) {
    $hours = ceil($time / 3600) % 24;
    $minutes = ceil($time / 60) % 60;
    $days = ceil($time / 86400);
    
    $timeString = $days . "D ". $hours . ":" . $minutes;
    
    return $timeString;
}

?>