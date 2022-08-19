<?php
require_once '../models/Find.php';
use php\models\Find;
//NOTE: may be reconstructed one day.
$find=new Find();
try {
    $found=$find->findUsername($_GET['username']);
    if($found){
        echo json_encode([
            'username'=>$_GET['username'],
            'status' => 'fail',
            'msg' => 'Username existed, please try another.',
        ], JSON_THROW_ON_ERROR);
    }
    else{
        echo json_encode([
            'username'=>$_GET['username'],
            'status' => 'success',
            'msg' => 'OK',
        ], JSON_THROW_ON_ERROR);
    }
}catch (Exception $exception){
    try {
        echo json_encode([
            'username'=>$_GET['username'],
            'status' => 'fail',
            'msg' => $exception->getMessage(),
        ], JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
    }
}