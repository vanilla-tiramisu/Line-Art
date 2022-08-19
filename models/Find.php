<?php

namespace php\models;
require_once 'Base.php';

use Exception;
//NOTE: may be reconstructed one day.

class Find extends Base
{
    public function findUsername($text):bool{
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
    public function findEmail($text):bool{
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
    public function showAllItems(){
        try {
            $sql = "SELECT * FROM items";
            $result=$this->db->query($sql);
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}