<?php

use php\models\Find;
use php\models\Save;

require_once '../models/Save.php';
require_once '../models/Find.php';

$save = new Save();
$find = new Find();
try {
    session_start();
    if ($_SESSION["logged"] !== true) {
        echo $_SESSION["logged"];
        throw new Exception("Oops! Something wrong happened in fetching the file...");
    }
    $post_data = array();
    $post_data['id'] = $_GET['id'];
//    echo $post_data['id'];
    if($find->getUsername()!==$find->showItemById($post_data['id'])['user']){
        throw new Exception("Sorry, you don't have the permission to edit");
    }
    //提取数组中的内容发给服务器
    $post_data['title'] = $_POST['title'];
    $post_data['artist'] = $_POST['artist'];
    $post_data['genre'] = $_POST['genre'];
    $post_data['creation'] = $_POST['creation'];
    $post_data['height'] = $_POST['height'];
    $post_data['width'] = $_POST['width'];
    $post_data['price'] = $_POST['price'];
    $post_data['description'] = $_POST['description'];
    $post_data['unit'] = $_POST['unit'];
    if (isset($_POST['BC'])) {
        $post_data['price'] = '-' . $post_data['price'];
    }
    $save->updateItem($post_data);
    echo json_encode([
        'status' => 'success',
        'msg' => 'Updated successfully!',
        'id' => $post_data['id']
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