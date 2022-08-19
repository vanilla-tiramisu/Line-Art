<?php
require_once '../models/Find.php';
use php\models\Find;

$find=new Find();
try {
    $result=$find->showAllItems();
            echo json_encode([
            'result'=>$result,
            'status' => 'success',
//            'msg' => 'Email already registered, please turn to login.',
        ], JSON_THROW_ON_ERROR);
//    if($result){
//        echo json_encode([
//            'email'=>$_GET['email'],
//            'status' => 'fail',
//            'msg' => 'Email already registered, please turn to login.',
//        ], JSON_THROW_ON_ERROR);
//    }
//    else{
//        echo json_encode([
//            'email'=>$_GET['email'],
//            'status' => 'success',
//            'msg' => 'OK',
//        ], JSON_THROW_ON_ERROR);
//    }
}catch (Exception $exception){
    try {
        echo json_encode([
            'email'=>$_GET['email'],
            'status' => 'fail',
            'msg' => $exception->getMessage(),
        ], JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
    }
}