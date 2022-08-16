<?php
require_once '../models/Search.php';
use php\models\Search;
//NOTE: may be reconstructed one day.
$search=new Search();
try {
    $found=$search->searchUsername($_GET['username']);
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