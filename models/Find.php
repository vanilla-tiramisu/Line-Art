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
            $sql = "SELECT * FROM users WHERE username=:username";
            $sql=$this->db->prepare($sql);
            $result=$sql->execute(array(':username'=>$text));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            //result:PDO对象(PDOStatement)
            //若结果集能够返回一次数据，则非空，表明用户名已占用
            return !empty($sql->fetch());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
    public function findEmail($text):bool{
        try {
            $sql = "SELECT * FROM users WHERE email=:email";
            $sql=$this->db->prepare($sql);
            $result=$sql->execute(array(':email'=>$text));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return !empty($sql->fetch());
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
    public function showItemById($id){
        try {
            $sql = "SELECT * FROM items where id=:id";
            $sql=$this->db->prepare($sql);
            $result=$sql->execute(array(':id'=>$id));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetch(\PDO::FETCH_ASSOC));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
    public function VisitingAnItem($id){
        try {
            $sql = "UPDATE items SET visit:=visit+1
                    WHERE id=:id";
            $sql=$this->db->prepare($sql);
            $result=$sql->execute(array(':id'=>$id));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetch(\PDO::FETCH_ASSOC));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
    public function getUsername():string{
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            if (isset($_SESSION['username'])){
                return $_SESSION['username'];
            }
            $sql = "SELECT * FROM users WHERE email=:email";
            $sql=$this->db->prepare($sql);
            $result=$sql->execute(array(':email'=>$_SESSION['email']));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetch())['username'];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}