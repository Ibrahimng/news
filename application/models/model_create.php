<?php

class Model_Create extends Model
{
    public function set_data()
    {
        $host = 'localhost';
        $user = 'root';
        $password = 'muscle';
        $database = 'articles';

        if (isset($_POST['add'])) {

        $mysqli = new mysqli($host, $user, $password, $database);
        if ($mysqli->connect_error)
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        mysqli_set_charset($mysqli, "utf8");

        $dir = './upload/';

        $a_filepath = "";

        $a_title = mysql_real_escape_string(isset($_POST['a-title']) ? $_POST['a-title'] : "");
        $a_text = mysql_real_escape_string(isset($_POST['a-text']) ? $_POST['a-text'] : "");
        $a_date = date("Y-m-d H:i:s", isset($_POST['a-date']) ? strtotime($_POST['a-date']): time());

        //если есть файл
        if (isset($_FILES["a-file"])) {

            $upfile = $_FILES['a-file']['tmp_name'];
            $upfile_name = $_FILES['a-file']['name'];
            $upfile_size = $_FILES['a-file']['size'];
            $upfile_type = $_FILES['a-file']['type'];
            $error_code = $_FILES['a-file']['error'];


            if($error_code == 0) {

                $info .= "Filename on server: " . $upfile . "<br>";
                $info .= "Filename on user desktop: " . $upfile_name . "<br>";
                $info .= "MIME type of file: " . $upfile_type . "<br>";
                $info .= "File size: " . $upfile_size . "<br>";

                $upfile_name = $dir . $upfile_name;

                move_uploaded_file($upfile, $upfile_name);
                $a_filepath = $upfile_name;
                $a_filepath = $mysqli->real_escape_string($a_filepath);
            }
            else {
                $info = $error_code . "what?";
            }
        }

        //записываю в БД
        header('Content-Type: text/html; charset=utf-8');
            $q = "INSERT INTO article (a_date, a_title, a_text, a_filepath) values ('$a_date', '$a_title', '$a_text', '$a_filepath')";
        $mysqli->query($q);
        if ($mysqli->errno) {
            $info .= 'Select Error (' . $mysqli->errno . ') ' . $mysqli->error;
        }
}

        return $info;
    }
    public function get_data()
    {

        return array(

            array(
                'Year' => '2012',
                'Site' => 'http://DunkelBeer.ru',
                'Description' => 'Промо-сайт темного пива Dunkel от немецкого производителя Löwenbraü выпускаемого в России пивоваренной компанией "CАН ИнБев".'
            ),
            array(
                'Year' => '2012',
                'Site' => 'http://ZopoMobile.ru',
                'Description' => 'Русскоязычный каталог китайских телефонов компании Zopo на базе Android OS и аксессуаров к ним.'
            ),
// todo
        );
    }
}