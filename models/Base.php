<?php
namespace php\models;
require_once '../common/Db.php';

use php\common\Db;

class Base{
    protected $config=[
        'host'=>'127.0.0.1',
        'user'=>'root',
        'pass'=>'shengcheng224',
        'dbname'=>'line_art'
    ];
    public $db=null;
//    classes that inherit from the Base will connect to the database
//    on creation.

    public function __construct(){
        try {
            $this->db=Db::getInstance(
                $this->config['host'],
                $this->config['user'],
                $this->config['pass'],
                $this->config['dbname']
            );
        }catch (\Exception $exception){
            echo $exception->getMessage();
            die;
        }
    }
}