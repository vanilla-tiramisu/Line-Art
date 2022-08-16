<?php
require_once '../models/Account.php';
use php\models\Account;

$account=new Account();

try {
    parse_str(file_get_contents('php://input'),$data);
    $account->addAccount($data);
        echo json_encode([
            'status' => 'success',
            'msg' => 'Registered successfully!',
        ], JSON_THROW_ON_ERROR);
}catch (\Exception $exception){
    try {
        echo json_encode([
            'status' => 'fail',
            'msg' => $exception->getMessage(),
        ], JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
    }
}