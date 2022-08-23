<?php

use php\models\Find;
use php\models\Save;

require_once '../models/Save.php';
require_once '../models/Find.php';

$save = new Save();
$find = new Find();
try {
    session_start();
    if (!isset($_FILES['picfile']['error']) || $_FILES['picfile']['error'] !== 0 || $_SESSION["logged"] !== true) {
        echo $_FILES['picfile']['error'];
        echo $_SESSION["logged"];
        throw new Exception("Oops! Something wrong happened in fetching the file...");
    }
    //提取数组中的内容发给服务器
    $post_data = array();
    $name = "Line_Art_" . time() . '.' . pathinfo($_FILES['picfile']['name'], PATHINFO_EXTENSION);
    $post_data['picfile'] = $name;
    $post_data['title'] = $_POST['title'];
    $post_data['artist'] = $_POST['artist'];
    $post_data['genre'] = $_POST['genre'];
    $post_data['creation'] = $_POST['creation'];
    $post_data['height'] = $_POST['height'];
    $post_data['width'] = $_POST['width'];
    $post_data['price'] = $_POST['price'];
    $post_data['description'] = $_POST['description'];
    $post_data['unit'] = $_POST['unit'];
    $post_data['username'] = $find->getUsername();
    if (isset($_POST['BC'])) {
        $post_data['price'] = '-' . $post_data['price'];
    }
    $save->uploadItem($post_data);
    //移动文件位置
    $target = '../img/' . $name;
    if (!move_uploaded_file($_FILES['picfile']['tmp_name'], $target)) {
        throw new Exception("Oops! Something wrong happened in saving the file ...");

    }
    echo json_encode([
        'status' => 'success',
        'msg' => 'Uploaded successfully!',
        'id' => $save->getId()
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