<?php

date_default_timezone_set('America/Los_Angeles');

spl_autoload_register(function($clase){
    //echo "include: ". str_replace('\\','/', $clase).".php <br>";
    if (file_exists(str_replace('\\','/', $clase).".php")){
        require_once str_replace('\\','/', $clase).".php";
    }
});
