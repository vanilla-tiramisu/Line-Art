<?php
namespace php\common;
use PDO;
//singleton mode.
class Db{
    protected $host='';
    protected $user='';
    protected $pass='';
    protected $select_db='';

    public static $pdo_con=null;

    private function __construct($host,$user,$pass,$select_db){
        $host&&$this->host=$host;
        $user&&$this->user=$user;
        $pass&&$this->pass=$pass;
        $select_db&&$this->select_db=$select_db;

    }

    public static function getInstance($host,$user,$pass,$select_db){
//    return an exist instance (if there's any)
        if (static::$pdo_con){
            return self::$pdo_con;
        }
//    create a new instance if there's none.
        if(!($host&&$user&&$pass&&$select_db)){
            throw new \Exception('Missing parameters in database connection!');
        }
        $db=new self($host,$user,$pass,$select_db);
        $db->_connect();
        return self::$pdo_con;
    }

    protected function _connect(): void
    {
        try {
            self::$pdo_con=new PDO(
                "mysql:host=$this->host;dbname=$this->select_db",
                $this->user,
                $this->pass,
                [PDO::ATTR_PERSISTENT=>true]
            );
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

}