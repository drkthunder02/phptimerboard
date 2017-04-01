<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function ConvertTime($time) {
    $hours = floor($time / 3600);
    $minutes = floor(($time / 60) % 60);
    $seconds = $time % 60;
    
    $timeString = $hours . ":" . $minutes . ":" . $seconds;
    
    return $timeString;
}

?>