<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../..");

function logger($message, $file='debug') {

    if(!is_dir ($_SERVER["DOCUMENT_ROOT"]."/local/log")){
        mkdir($_SERVER["DOCUMENT_ROOT"]."/local/log");
    }

    $date = date('d.m.Y h:i:s');
    $log ="|  Date:  ".$date."  |   ".$message;
    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/local/log/$file.log", $log . PHP_EOL, FILE_APPEND);
}

