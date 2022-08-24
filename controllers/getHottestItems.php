<?php
require_once '../models/Find.php';
use php\models\Find;
$find=new Find();
try {
    echo json_encode([
        'msg'=>$find->getHottestItems(),
        'status' => 'success',
    ], JSON_THROW_ON_ERROR);
}catch (Exception $exception){
    try {
        echo json_encode([
            'status' => 'fail',
            'msg' => $exception->getMessage(),
        ], JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
    }
}