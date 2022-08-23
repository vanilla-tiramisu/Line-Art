<?php

namespace php\models;
require_once 'Base.php';

use Exception;

class Save extends Base
{
    protected string $picfile = '';
    protected string $title = '';
    protected string $artist = '';
    protected string $genre = '';
    protected string $creation = '';
    protected string $height = '';
    protected string $width = '';
    protected string $price = '';
    protected string $description = '';
    protected string $unit = 'cm';
    protected string $username = 'admin';
    protected string $id = '';


    public function uploadItem($post_data): void
    {
        isset($post_data['picfile']) && $this->picfile = $post_data['picfile'];
        isset($post_data['title']) && $this->title = $post_data['title'];
        isset($post_data['artist']) && $this->artist = $post_data['artist'];
        isset($post_data['genre']) && $this->genre = $post_data['genre'];
        isset($post_data['creation']) && $this->creation = $post_data['creation'];
        isset($post_data['height']) && $this->height = $post_data['height'];
        isset($post_data['width']) && $this->width = $post_data['width'];
        isset($post_data['price']) && $this->price = $post_data['price'];
        isset($post_data['description']) && $this->description = $post_data['description'];
        isset($post_data['unit']) && $this->unit = $post_data['unit'];
        isset($post_data['username']) && $this->username = $post_data['username'];

        //空白不录入
        if ($this->picfile === '' || $this->price === '' || $this->title === '') {
            echo $this->picfile;
            echo $this->price;
            echo $this->title;
            throw new Exception("Please fill in all the required blanks!");
        }
        //长度过长禁止录入
        if (preg_match("/.{129,}/", $this->title)) {
            throw new Exception("Please check the title's length!");
        }
        if (preg_match("/.{129,}/", $this->artist)) {
            throw new Exception("Please check the artist name's length!");
        }
        if (preg_match("/.{51,}/", $this->genre)) {
            throw new Exception("Please check the title's length!");
        }
        if (preg_match("/.{5,}/", $this->creation)) {
            throw new Exception("Please check creation section!");
        }
        if (preg_match("/.{11,}/",$this->price)){
            throw new Exception("Would anybody be able to pay?");
        }
        //空值初始化
        if ($this->artist === '') {
            $this->artist = "anonymous artist";
        }
        if ($this->genre === '') {
            $this->genre = "unknown";
        }
        if ($this->creation === '') {
            $this->creation = '9999';
        }
        if ($this->height === '') {
            $this->height = '0';
        }
        if ($this->width === '') {
            $this->width = '0';
        }
        if ($this->description === '') {
            $this->description = "There's no description for this item yet.";
        }
        //小数校验
        if (!preg_match("/\d*(\.\d*)?/", $this->width) || !preg_match("/\d*(\.\d*)?/", $this->height)) {
            throw new Exception("Please fill in numbers in the width and the height field!");
        }

        try {

            $sql = "
                INSERT INTO items(filename, title, artist, price, sold, user, 
                                  create_date, width, height, length_unit,genre, description) 
                VALUES (:filename, :title, :artist, :price, :sold, :user, 
                                  :create_date, :width, :height, :unit,:genre, :description)";
            $statement = $this->db->prepare($sql);
            $result = $statement->execute(array(':filename' => $this->picfile, ':title' => $this->title,
                ':artist' => $this->artist, ':price' => $this->price, ':sold' => 0,
                ':user' => $this->username, ':create_date' => $this->creation, ':width' => $this->width,
                ':height' => $this->height, ':unit' => $this->unit, ':genre' => $this->genre, ':description' => $this->description));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
    public function updateItem($post_data): void
    {
        isset($post_data['id']) && $this->id = $post_data['id'];
        isset($post_data['title']) && $this->title = $post_data['title'];
        isset($post_data['artist']) && $this->artist = $post_data['artist'];
        isset($post_data['genre']) && $this->genre = $post_data['genre'];
        isset($post_data['creation']) && $this->creation = $post_data['creation'];
        isset($post_data['height']) && $this->height = $post_data['height'];
        isset($post_data['width']) && $this->width = $post_data['width'];
        isset($post_data['price']) && $this->price = $post_data['price'];
        isset($post_data['description']) && $this->description = $post_data['description'];
        isset($post_data['unit']) && $this->unit = $post_data['unit'];
        isset($post_data['username']) && $this->username = $post_data['username'];

        //空白不录入
        if ($this->price === '' || $this->title === '') {
            echo $this->price;
            echo $this->title;
            throw new Exception("Please fill in all the required blanks!");
        }
        //长度过长禁止录入
        if (preg_match("/.{129,}/", $this->title)) {
            throw new Exception("Please check the title's length!");
        }
        if (preg_match("/.{129,}/", $this->artist)) {
            throw new Exception("Please check the artist name's length!");
        }
        if (preg_match("/.{51,}/", $this->genre)) {
            throw new Exception("Please check the title's length!");
        }
        if (preg_match("/.{5,}/", $this->creation)) {
            throw new Exception("Please check creation section!");
        }
        if (preg_match("/.{11,}/",$this->price)){
            throw new Exception("Would anybody be able to pay?");
        }
        //空值初始化
        if ($this->artist === '') {
            $this->artist = "anonymous artist";
        }
        if ($this->genre === '') {
            $this->genre = "unknown";
        }
        if ($this->creation === '') {
            $this->creation = '9999';
        }
        if ($this->height === '') {
            $this->height = '0';
        }
        if ($this->width === '') {
            $this->width = '0';
        }
        if ($this->description === '') {
            $this->description = "There's no description for this item yet.";
        }
        //小数校验
        if (!preg_match("/\d*(\.\d*)?/", $this->width) || !preg_match("/\d*(\.\d*)?/", $this->height)) {
            throw new Exception("Please fill in numbers in the width and the height field!");
        }

        try {

            $sql = "
                UPDATE items  
                SET title=:title, artist=:artist, price=:price,create_date=:create_date,
                    width=:width, height=:height, length_unit=:unit,genre=:genre,
                    description=:description
                WHERE id=:id";
            $statement = $this->db->prepare($sql);
            $result = $statement->execute(array(':title' => $this->title,
                ':artist' => $this->artist, ':price' => $this->price,
                ':create_date' => $this->creation, ':width' => $this->width,
                ':height' => $this->height, ':unit' => $this->unit, ':genre' => $this->genre,
                ':description' => $this->description,':id'=>$this->id));
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getId():string
    {
        try {
            $sql = "SELECT LAST_INSERT_ID()";
            $result = $this->db->query($sql);
            if ($result === false) {
                throw new Exception($this->db->errorInfo()[2]);
            }
            return $result->fetchAll(\PDO::FETCH_ASSOC)[0]['LAST_INSERT_ID()'];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
