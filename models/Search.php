<?php

namespace php\models;
require_once 'Base.php';

use Exception;
//NOTE: may be reconstructed one day.

class Search extends Base
{
    public function searchUsername($text):bool{
//        echo $text;
        try {
            $sql = "SELECT * FROM users WHERE username='".$text."'";
            $result=$this->db->query($sql);
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            //result:PDO对象(PDOStatement)
            //若结果集能够返回一次数据，则非空，表明用户名已占用
            return !empty($result->fetch());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
    public function searchEmail($text):bool{
        try {
            $sql = "SELECT * FROM users WHERE email='".$text."'";
            $result=$this->db->query($sql);
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return !empty($result->fetch());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}