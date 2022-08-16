<?php
require_once '../models/Search.php';
use php\models\Search;
//NOTE: may be reconstructed one day.
$search=new Search();
try {
    $found=$search->searchEmail($_GET['email']);
    if($found){
        echo json_encode([
            'email'=>$_GET['email'],
            'status' => 'fail',
            'msg' => 'Email already registered, please turn to login.',
        ], JSON_THROW_ON_ERROR);
    }
    else{
        echo json_encode([
            'email'=>$_GET['email'],
            'status' => 'success',
            'msg' => 'OK',
        ], JSON_THROW_ON_ERROR);
    }
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