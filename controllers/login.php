<?php
require_once '../models/Account.php';
require_once '../models/Find.php';

use php\models\Account;
use php\models\Find;

$account = new Account();
$find = new Find();
try {
    parse_str(file_get_contents('php://input'), $data);
    $username = $data['username'];
    $password = $data['password'];
    //空白不录入
    if (!($username && $password)) {
        throw new Exception("Please fill in all the blanks!");
    }
    //长度过长禁止录入
    if (preg_match("/.{21,}/", $password)) {
        throw new Exception("Please enter the right password!");
    }
    $copy = preg_replace("/[\w-]+@[\w-]+\.[\w-]+/", "", $username);
    if ($copy === "" && !preg_match("/.{51,}/", $username)) {
        //输入的是邮箱
        if ($find->findEmail($username)) {
            if(!$account->loginByEmail($username,$password)){
                throw new Exception("Wrong password, please try again.");
            }
            session_start();
            setcookie(session_name(),session_id(),strtotime('+100 hours'),'/');
            $_SESSION["logged"]=true;
            $_SESSION["email"]=$username;
        } else {
            throw new Exception("Username not found, please check your input.");
        }
    } else if (!preg_match("/[^\w-]+/", $username)
        && !preg_match("/.{20,}/", $username)) {
        //输入的是用户名
        if ($find->findUsername($username)) {
            if(!$account->loginByUsername($username,$password)){
                throw new Exception("Wrong password, please try again.");
            }
            session_start();
            setcookie(session_name(),session_id(),strtotime('+100 hours'),'/');
            $_SESSION["logged"]=true;
            $_SESSION["username"]=$username;
        } else {
            throw new Exception("Username not found, please check your input.");
        }
    } else {
        throw new Exception("Please enter an available username!");
    }
    echo json_encode([
        'status' => 'success',
        'msg' => 'Logged in successfully!',
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