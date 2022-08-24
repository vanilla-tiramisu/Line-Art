<?php

namespace php\models;
require_once 'Base.php';

use Exception;

//NOTE: may be reconstructed one day.

class Find extends Base
{
    public function findUsername($text): bool
    {
//        echo $text;
        try {
            $sql = "SELECT * FROM users WHERE username=:username";
            $sql = $this->db->prepare($sql);
            $result = $sql->execute(array(':username' => $text));
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

    public function findEmail($text): bool
    {
        try {
            $sql = "SELECT * FROM users WHERE email=:email";
            $sql = $this->db->prepare($sql);
            $result = $sql->execute(array(':email' => $text));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return !empty($sql->fetch());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function showAllItems()
    {
        try {
            $sql = "SELECT * FROM items";
            $result = $this->db->query($sql);
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return $result->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function showItemById($id)
    {
        try {
            $sql = "SELECT * FROM items where id=:id";
            $sql = $this->db->prepare($sql);
            $result = $sql->execute(array(':id' => $id));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetch(\PDO::FETCH_ASSOC));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function VisitingAnItem($id)
    {
        try {
            $sql = "UPDATE items SET visit:=visit+1
                    WHERE id=:id";
            $sql = $this->db->prepare($sql);
            $result = $sql->execute(array(':id' => $id));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetch(\PDO::FETCH_ASSOC));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getUsername(): string
    {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            if (isset($_SESSION['username'])) {
                return $_SESSION['username'];
            }
            $sql = "SELECT * FROM users WHERE email=:email";
            $sql = $this->db->prepare($sql);
            $result = $sql->execute(array(':email' => $_SESSION['email']));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetch())['username'];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getLatestItems()
    {
        try {
            $sql = "SELECT * FROM `items` ORDER BY `items`.`id` DESC limit 5 offset 0;";
            $sql = $this->db->prepare($sql);
            $result = $sql->execute();
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetchAll(\PDO::FETCH_ASSOC));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getHottestItems()
    {
        try {
            $sql = "SELECT * FROM `items` ORDER BY `items`.`visit` DESC limit 7 offset 0;";
            $sql = $this->db->prepare($sql);
            $result = $sql->execute();
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetchAll(\PDO::FETCH_ASSOC));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getSearchedItems($params)
    {
        try {
            $basicPart = "SELECT * FROM `items` ";
            //page
            $page = $params['page'];
            if (!preg_match("/[1-9]\d*/", $page)) {
                throw new Exception("Not a valid page number!");
            }
            $offset = 8 * ($page - 1);
            $pagePart = "limit 8 offset " . $offset;
            //style
            $style = $params['style'];
            if ($style === 'byVisit') {
                $stylePart = "ORDER BY visit DESC ";
            } elseif ($style === 'byName') {
                $stylePart = "ORDER BY title ";
            } elseif ($style === 'byPrice') {
                $stylePart = "ORDER BY price DESC ";
            } else {
                throw new Exception("Not a valid style!");
            }
            //range
            $range = $params['range'];
            if ($range === 'title') {
                $rangePart = "WHERE title LIKE :keyword ";
            } elseif ($range === 'artist') {
                $rangePart = "WHERE artist LIKE :keyword ";
            } else {
                throw new Exception("Not a valid range!");
            }
            //keyword
            $keyword = $params['keyword'];
            if ($keyword !== '') {
                $sql = $basicPart . $rangePart . $stylePart . $pagePart;
                //SELECT * FROM `items` WHERE title LIKE :keyword ORDER BY visit DESC
                // limit 8 offset ...
                $keyword = '%' . $keyword . '%';
                $sql = $this->db->prepare($sql);
                $sql->bindParam(':keyword', $keyword, \PDO::PARAM_STR);
            } else {
                $sql = $basicPart . $stylePart . $pagePart;
                $sql = $this->db->prepare($sql);
            }
            $result = $sql->execute();
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return ($sql->fetchAll(\PDO::FETCH_ASSOC));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}