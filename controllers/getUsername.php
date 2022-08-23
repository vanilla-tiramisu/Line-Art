<?php
require_once '../models/Find.php';
use php\models\Find;
$find=new Find();
try {
    $username=$find->getUsername();
    if($username){
        echo json_encode([
            'msg'=>$username,
            'status' => 'success',
        ], JSON_THROW_ON_ERROR);
    }
    else{
        echo json_encode([
            'status' => 'fail'
        ], JSON_THROW_ON_ERROR);
    }
}catch (Exception $exception){
    try {
        echo json_encode([
            'status' => 'fail',
            'msg' => $exception->getMessage(),
        ], JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
    }
}