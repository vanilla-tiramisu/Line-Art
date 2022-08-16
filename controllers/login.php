<?php
require_once '../models/Account.php';
require_once '../models/Search.php';

use php\models\Account;
use php\models\Search;

$account = new Account();
$search = new Search();
//TODO:判断前端通过POST发过来的信息是否有效；若有效，则交给Account进一步处理。
try {
    parse_str(file_get_contents('php://input'), $data);
    $username = $data['username'];
    $password = $data['password'];
    //空白不录入
    if (!($this->username && $this->password)) {
        throw new Exception("Please fill in all the blanks!");
    }
    //长度过长禁止录入
    if (preg_match("/.{21,}/", $this->password)) {
        throw new Exception("Please enter the right password!");
    }
    $copy = preg_replace("/[\w-]+@[\w-]+\.[\w-]+/", "", $this->username);
    if ($copy === "" && !preg_match("/.{51,}/", $this->username)) {
        //输入的是邮箱
        if ($search->searchUsername($this->username)) {
            $account->loginByUsername($this->username, $this->password);
        } else {
            throw new Exception("Username not found, please check your input.");
        }
    } else if (!preg_match("/[^\w-]+/", $this->username)
        && !preg_match("/.{20,}/", $this->username)) {
        //输入的是用户名
        if ($search->searchEmail($this->username)) {
            $account->loginByEmail($this->username,$this->password);
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