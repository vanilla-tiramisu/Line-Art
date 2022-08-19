<?php

try {
    session_start();
    if(isset($_SESSION['logged'])&&$_SESSION['logged']===true) {
        //重置会话中的变量
        $_SESSION=array();
        $params=session_get_cookie_params();
        setcookie(session_name(),'',1,$params["path"]);
        session_destroy();
        echo json_encode([
            'status' => 'success',
            'msg'=>'Logged out now'
        ], JSON_THROW_ON_ERROR);
    }else{
        echo json_encode([
            'status' => 'fail',
            'msg'=>'Sorry, an error happened.'
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