<?php

class Model_Create extends Model
{
    public function set_data()
    {
        $info = "";
        if (isset($_POST['add'])) {

        $dir = './upload/';

        $errors = array();

        if (!isset($_POST['a-title']) or empty($_POST['a-title']) or mb_strlen($_POST['a-title'], 'utf-8') < 3 or mb_strlen($_POST['a-title'], 'utf-8') > 50) {
            $errors[] = "У новости должно быть название, длиной от 3 до 50 символов";
        }
        if (!isset($_POST['a-text']) or empty($_POST['a-text']) or mb_strlen($_POST['a-text'], 'utf-8') < 10 or mb_strlen($_POST['a-text'], 'utf-8') > 140) {
            $errors[] = "У новости должен быть текст, длиной от 10 до 140 символов";
        }
        if (!isset($_POST['a-date']) or empty($_POST['a-date'])) {
            $errors[] = "У новости должна быть дата";
        }
        else {
            $unix_time = strtotime($_POST['a-date']);
        }

        //если есть файл
        if (isset($_FILES["a-file"])) {

            $upfile = $_FILES['a-file']['tmp_name'];
            $error_code = $_FILES['a-file']['error'];

            if($error_code == 0) {
                $upfile_name = "photo_" . time() . ".jpg";
                move_uploaded_file($upfile, $dir . $upfile_name);
                $a_filepath = $upfile_name;
            }
            else {
                switch ($error_code) {
                    case 1: $errors[] = "Размер файла привысил максимально допустимый размер, установленный на сервере";
                        break;
                }
            }
        }
        else {
            $a_filepath = "";
        }

        if (isset($unix_time) and $unix_time)
            $a_date = date("Y-m-d H:i:s", strtotime($_POST['a-date']));
        else
            $errors[] = "Допустимый формат для даты: дд.мм.ГГГГ";

        //записываю в БД
        if (count($errors) == 0) {

            $a_title = mysql_real_escape_string($_POST['a-title']);
            $a_text = mysql_real_escape_string($_POST['a-text']);

            $q = "INSERT INTO article (a_date, a_title, a_text, a_filepath) values ('$a_date', '$a_title', '$a_text', '$a_filepath')";
            $this->mysqli->query($q);
            if ($this->mysqli->errno) {
                $info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
            }
            header ("Location: /");
        }
        return $errors;
}


    }
}