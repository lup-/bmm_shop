<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

$time_limit = ini_get('max_execution_time');
$memory_limit = ini_get('memory_limit');

set_time_limit(0);
ini_set('memory_limit', '-1');

$remote_contents = file_get_contents('php://input');
$success = false;

if($remote_contents){
    $fileName = $DOCUMENT_ROOT.'/local/json/data.json';
    if(file_exists($fileName)) {
        unlink($fileName);
    }
    file_put_contents($fileName,$remote_contents);
    $success = true;
}

set_time_limit($time_limit);
ini_set('memory_limit', $memory_limit);

header("Content-type: application/json; charset=utf-8");
$result =  [
    'success' => $success
];
echo json_encode($result);
?>
