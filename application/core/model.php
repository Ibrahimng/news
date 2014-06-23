<?php

class Model
{
private $host = 'localhost';
private $user = 'root';
private $password = 'muscle';
private $database = 'articles';

protected $mysqli;

 function __construct()
 {
     $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);
     if ($this->mysqli->connect_error)
         die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $mysqli->connect_error);
     mysqli_set_charset($this->mysqli, "utf8");
 }
    public function get_data()
    {
    }
}