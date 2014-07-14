<?php

class Model_Article extends Model
{

    public $dir = './upload/';
    public $info = "";
    public $default_image = "default-image.gif";

    public function set_data()
    {

        $info = "";
        $return = array(
            'errors' => array(),
            'tags' => array()
        );
        if (isset($_POST['add'])) {
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

            $tags = array();
            if (isset($_POST['a-tag']))
                $tags = $_POST['a-tag'];
            if (is_array($tags)) {
                $return['tags'] = $tags;
            }

            //если есть файл
            if (isset($_FILES["a-file"])) {

                $upfile = $_FILES['a-file']['tmp_name'];
                $error_code = $_FILES['a-file']['error'];

                if($error_code == 0) {
                    $upfile_name = "photo_" . time() . ".jpg";
                    move_uploaded_file($upfile, $this->dir . $upfile_name);
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

                $new_article_id = $this->mysqli->insert_id;

                //сохраним в базе информацию о тегах
                foreach ($tags as $key => $value) {
                    $q = "insert into at_dict (article_id, tag_id) values (" . $new_article_id . "," . $value . ")";
                    $this->mysqli->query($q);
                    if ($this->mysqli->errno) {
                        $this->info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
                    }
                }
                header ("Location: /");
            }
            else
                $return['errors'] = $errors;
        }
        $query = "select * from tag";
        if ($result = $this->mysqli->query($query)) {

            while ($row = $result->fetch_assoc()) {

                array_push($return['tags'], $row);

            }

            $result->free();
        }
        return $return;

    }

    public function validate($data = array()) {

        $errors = array();
        $return = array(
            'error'  => 1,
            'data'   => array(
                'a_date' => '',
                'a_title' => '',
                'a_text' => '',
                'a_filepath' => '',
                'a_hidden' => '',
                'a_id' => '',
                'a_old_filepath' => ''
            ),
            'errors' => array(),
            'tags' => array()
        );

        if (!isset($_POST['a-id']) or empty($_POST['a-id'])) {
            $errors[] = "На задан id новости для внесения изменений";
        }

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
            if ($unix_time)
                $return['data']['a_date'] = date("Y-m-d H:i:s", strtotime($_POST['a-date']));
            else
                $errors[] = "Допустимый формат для даты: дд.мм.ГГГГ";
        }
        $tags = array();
        if (isset($_POST['a-tag']))
            $tags = $_POST['a-tag'];
        if (is_array($tags)) {
            $return['tags'] = $tags;
        }

        $return['data']['a_title'] = mysql_real_escape_string($_POST['a-title']);
        $return['data']['a_text'] = mysql_real_escape_string($_POST['a-text']);
        $return['data']['a_id'] = mysql_real_escape_string($_POST['a-id']);
        $return['data']['a_old_filepath'] = mysql_real_escape_string($_POST['a-old-filepath']);


        if (isset($_POST['a-hidden']))
            $return['data']['a_hidden'] = mysql_real_escape_string($_POST['a-hidden']);

        //если есть файл
        if (isset($_FILES["a-file"])) {

            $upfile = $_FILES['a-file']['tmp_name'];
            $error_code = $_FILES['a-file']['error'];

            if($error_code == 0) {
                $upfile_name = "photo_" . time() . ".jpg";
                move_uploaded_file($upfile, $this->dir . $upfile_name);
                $a_filepath = $upfile_name;
                $return['data']['a_filepath'] = $a_filepath;

            }
            else {
                switch ($error_code) {
                    case 1: $errors[] = "Размер файла привысил максимально допустимый размер, установленный на сервере";
                        break;
                }
            }
        }

        $return['errors'] = $errors;

        if(empty($errors)) {
            $return['error'] = 0;
        }
        return $return;
    }

    public function get_article()
    {
        $data_to_paste = array(
            'article' => array(),
            'tag' => array()
        );

        if (isset($_GET['id'])) {
            $article_id = (int)mysql_real_escape_string($_GET['id']);

            $query = "select * from article where id=$article_id";

            if ($result = $this->mysqli->query($query)) {

                $row = $result->fetch_assoc();
                if($row)
                    $data_to_paste['article'] = $row;

                $result->free();
            }

            $query = "select * from tag";
            if ($result = $this->mysqli->query($query)) {

                while ($row = $result->fetch_assoc()) {

                    array_push($data_to_paste['tag'], $row);

                }

                $result->free();
            }

            $query = "select tag_id from at_dict where article_id=$article_id";
            if ($result = $this->mysqli->query($query)) {

                while ($row = $result->fetch_assoc()) {
                    foreach($data_to_paste['tag'] as &$tag) {
                        if ($tag['id'] == $row['tag_id'])
                            $tag['selected'] = 1;
                    }

                }

                $result->free();
            }

            return $data_to_paste;
        }
    }

    public function update_article($data, $tags)
    {
        $filepath_to_insert = "";
        if ($data['a_filepath'] == '')
            $data['a_filepath'] = $data['a_old_filepath'];

        //если файл изменен, удаляю старый файл
        if ($data['a_old_filepath'] != '')
        {
            $old_file_path = $this->dir . $data['a_old_filepath'];
            if ($data['a_filepath'] != $data['a_old_filepath'] and $data['a_filepath'] != "''") {
                unlink($old_file_path);
            }
        }

        $data = array_map(function ($v) {
            return "'" . str_replace("'", '"', $v) . "'";
        }, $data);

        $q = "update article set a_title=" . $data['a_title'] . ", a_text=" . $data['a_text'] . ", a_date=" . $data['a_date'] . ", a_filepath=" .  $data['a_filepath'] . ", a_hidden=" . $data['a_hidden']  . " where id=" . $data['a_id'];

        $this->mysqli->query($q);
        if ($this->mysqli->errno) {
            $this->info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
        }



        //удалим все старые записи о тегах
        $q = "delete from at_dict where article_id=" . $data['a_id'];
        $this->mysqli->query($q);
        if ($this->mysqli->errno) {
            $this->info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
        }
        //сохраним в базе информацию о тегах
        foreach ($tags as $key => $value) {
            $q = "insert into at_dict (article_id, tag_id) values (" . $data['a_id'] . "," . $value . ")";
            $this->mysqli->query($q);
            if ($this->mysqli->errno) {
                $this->info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
            }
        }

        header("Location: /");

    }

    public function delete_data()
    {
        if (isset($_GET['id'])) {
            $article_id = (int)mysql_real_escape_string($_GET['id']);
            $query = "delete from article where id=$article_id";

            $this->mysqli->query($query);

        }
        header("Location: /");

    }
}