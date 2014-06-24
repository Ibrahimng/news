<?php

class Model_Edit extends Model
{
    public function set_data()
    {
        $info = "";

        $data_to_paste = "";




        if (isset($_POST['save'])) {

            $dir = './upload/';

            $errors = array();

            if (!isset($_POST['a-title']) or empty($_POST['a-title']) or strlen($_POST['a-title']) < 3 or strlen($_POST['a-title']) > 50) {
                $errors[] = "У новости должно быть название, длиной от 3 до 50 символов";
            }
            if (!isset($_POST['a-text']) or empty($_POST['a-text']) or strlen($_POST['a-text']) < 10 or strlen($_POST['a-text']) > 140) {
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
                $upfile_name = $_FILES['a-file']['name'];
                $error_code = $_FILES['a-file']['error'];

                if($error_code == 0) {

                    $upfile_name = $dir . $upfile_name;
                    move_uploaded_file($upfile, $upfile_name);
                    $a_filepath = $upfile_name;
                    $a_filepath = $this->mysqli->real_escape_string($a_filepath);

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

        if (isset($_GET['id'])) {
            $article_id = mysql_real_escape_string($_GET['id']);

            $query = "select * from article where id=$$article_id";

            if ($result = $this->mysqli->query($query)) {

                /* извлечение ассоциативного массива */
                while ($row = $result->fetch_assoc()) {
                    array_push($data_to_paste, $row);
                }
                /* удаление выборки */
                $row = $result->fetch_assoc();
                if($row)
                    $data_to_paste = $row;

                $result->free();
            }

            return $data_to_paste;
        }


    }
}