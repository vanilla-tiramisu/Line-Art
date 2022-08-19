<?php

session_start();
try {
    if(isset($_SESSION['logged'])) {
        echo json_encode([
            'status' => 'success',
            'logged' => $_SESSION['logged']
        ], JSON_THROW_ON_ERROR);
    }else{
        echo json_encode([
            'status' => 'fail',
            'logged' => 'false'
        ], JSON_THROW_ON_ERROR);
    }

}catch (Exception $exception){
    try {
        echo json_encode([
            'status' => 'fail',
            'logged' => 'false',
            'msg' => $exception->getMessage(),
        ], JSON_THROW_ON_ERROR);
    } catch (Exception $e) {
    }
}