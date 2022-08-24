<?php
require_once '../models/Find.php';

use php\models\Find;

$find = new Find();
try {
    $params=array();
    $params['page']=1;
    $params['style']='byVisit';
    $params['range']='title';
    $params['keyword']='';
    if (isset($_GET['page'])) {
        $params['page']=$_GET['page'];
    }
    if (isset($_GET['style'])) {
        $params['style']=$_GET['style'];
    }
    if (isset($_GET['range'])) {
        $params['range']=$_GET['range'];
    }
    if (isset($_GET['keyword'])) {
        $params['keyword']=$_GET['keyword'];
    }
    $result=$find->getSearchedItems($params);
    echo json_encode([
        'result' => $result,
        'status' => 'success',
    ], JSON_THROW_ON_ERROR);

} catch (Exception $exception) {
    try {
        echo json_encode([
            'status' => 'fail',
            'msg' => $exception->getMessage(),
        ], JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
    }
}