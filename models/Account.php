<?php

namespace php\models;
require_once 'Base.php';

use Exception;

class Account extends Base
{
    protected string $username = '';
    protected string $password = '';
    protected string $email = '';
    protected string $phone = '';
    protected string $address = '';
    protected string $confirmed = '';

    public function addAccount($post_data): void
    {
        isset($post_data['username']) && $this->username = $post_data['username'];
        isset($post_data['password']) && $this->password = $post_data['password'];
        isset($post_data['email']) && $this->email = $post_data['email'];
        isset($post_data['phone']) && $this->phone = $post_data['phone'];
        isset($post_data['address']) && $this->address = $post_data['address'];
        isset($post_data['confirmed-password']) && $this->confirmed = $post_data['confirmed-password'];
        if (!($this->username && $this->password && $this->email && $this->phone && $this->address)) {
            throw new Exception("Please fill in all the blanks!");
        }
        if ($this->confirmed !== $this->password) {
            throw new Exception("Please enter the same password!");
        }
        if ($this->password === $this->username) {
            throw new Exception("Password cannot be as same as username!");
        }
        if (!preg_match("/\D+/", $this->password)) {
            throw new Exception("Password cannot be all numbers!");
        }
        if (!preg_match("/.{6,}/", $this->password)) {
            throw new Exception("Password length must not be less than 6 bits!");
        }
        if (preg_match("/[^\w.-]+/", $this->password)) {
            throw new Exception("Password should only contain letters, numbers, \"_\", \"-\" and \".\"!");
        }
        if (preg_match("/[^\w-]+/", $this->username)) {
            throw new Exception("Username should only contain letters, numbers, \"_\" and \"-\"!");
        }
        $copy=preg_replace("/[\w-]+@[\w-]+\.[\w-]+/", "", $this->email);
        if ($copy!=="") {
                throw new Exception("Please enter an available email!");
        }
        try {
            $sql = "
                INSERT INTO users(username, password, email, phone, address) 
                VALUES ('$this->username','$this->password','$this->email',
                        '$this->phone','$this->address') ";
            if ($this->db->exec($sql) === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function loginByUsername($username,$password): bool
    {
        try {
            $sql = "SELECT * FROM users WHERE username='" . $username . "'
            AND password='".$password."'";
            $result = $this->db->query($sql);
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

    public function loginByEmail($email,$password): bool
    {
        try {
            $sql = "SELECT * FROM users WHERE email='" . $email . "'
            AND password='".$password."'";
            $result = $this->db->query($sql);
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return !empty($result->fetch());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}
