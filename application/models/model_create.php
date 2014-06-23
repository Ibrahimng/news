<?php

class Model_Create extends Model
{
    public function set_data()
    {

        $info = "";
        if (isset($_POST['add'])) {

        $dir = './upload/';
        $a_filepath = "";
        $a_title = mysql_real_escape_string(!empty($_POST['a-title']) ? $_POST['a-title'] : "");
        $a_text = mysql_real_escape_string(!empty($_POST['a-text']) ? $_POST['a-text'] : "");
        $a_date = !empty($_POST['a-date']) ? date("Y-m-d H:i:s", strtotime($_POST['a-date'])) : '0000-00-00 00:00:00';

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
                $a_filepath = $this->mysqli->real_escape_string($a_filepath);
            }
            else {
                $info = $error_code;
            }
        }

        //записываю в БД

        $q = "INSERT INTO article (a_date, a_title, a_text, a_filepath) values ('$a_date', '$a_title', '$a_text', '$a_filepath')";
        $this->mysqli->query($q);
        if ($this->mysqli->errno) {
            $info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
        }
        header ("Location: /");
}


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