<?php

    class Model_Tag extends Model
    {
        public function set_data()
        {

            $info = "";
            $return = array(
                'errors' => array()
            );
            if (isset($_POST['add'])) {
                $errors = array();

                if (!isset($_POST['t-name']) or empty($_POST['t-name']) or mb_strlen($_POST['t-name'], 'utf-8') < 3 or mb_strlen($_POST['a-title'], 'utf-8') > 15) {
                    $errors[] = "У тэга должно быть название, длиной от 3 до 15 символов";
                }

                //записываю в БД
                if (count($errors) == 0) {

                    $t_name = mysql_real_escape_string($_POST['t-name']);

                    $q = "INSERT INTO tag (t_name) values ('$t_name')";
                    $this->mysqli->query($q);
                    if ($this->mysqli->errno) {
                        $info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
                    }

                    header ("Location: /");
                }
                else
                    $return['errors'] = $errors;
            }
            return $return;

        }

        public function validate($data = array()) {

            $errors = array();
            $return = array(
                'error'  => 1,
                'data'   => array(
                    't_name' => '',
                    't_id' => ''
                ),
                'errors' => array()
            );

            if (!isset($_POST['t-id']) or empty($_POST['t-id'])) {
                $errors[] = "На задан id тэга для внесения изменений";
            }

            if (!isset($_POST['t-name']) or empty($_POST['t-name']) or mb_strlen($_POST['t-name'], 'utf-8') < 3 or mb_strlen($_POST['a-title'], 'utf-8') > 15) {
                $errors[] = "У тэга должно быть название, длиной от 3 до 15 символов";
            }

            $return['data']['t_name'] = mysql_real_escape_string($_POST['t-name']);
            $return['data']['t_id'] = mysql_real_escape_string($_POST['t-id']);
            $return['errors'] = $errors;

            if(empty($errors)) {
                $return['error'] = 0;
            }
            return $return;
        }

        public function get_tag()
        {
            $data_to_paste = array(
                'tag' => array()
            );

            if (isset($_GET['id'])) {
                $tag_id = (int)mysql_real_escape_string($_GET['id']);

                $query = "select * from tag where id=$tag_id";

                if ($result = $this->mysqli->query($query)) {

                    $row = $result->fetch_assoc();
                    if($row)
                        $data_to_paste['tag'] = $row;

                    $result->free();
                }

                return $data_to_paste;
            }
        }

        public function update_tag($data)
        {

            $data = array_map(function ($v) {
                return "'" . str_replace("'", '"', $v) . "'";
            }, $data);

            $q = "update tag set t_name=" . $data['t_name']  . " where id=" . $data['t_id'];

            $this->mysqli->query($q);
            if ($this->mysqli->errno) {
                $this->info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
            }

            header("Location: /tag");

        }

        public function delete_data()
        {
            if (isset($_GET['id'])) {
                $tag_id = (int)mysql_real_escape_string($_GET['id']);
                $query = "delete from tag where id=$tag_id";

                $this->mysqli->query($query);

            }
            header("Location: /tag");

        }

        public function get_tags()
        {
            $return = array(
                'tags' => array(),
                'pagesCount' => 1,
                'currentPage' => 1,
                'active' => 1,
                'type' => ''
            );
            $tags = array();
            $in_clause = "";

            $start = 0;
            $limit = 2;
            $current_page = 1;

            if (isset($_GET['page']))
            {
                $current_page = $_GET['page'];
                if ($current_page > 1)
                    $start += $limit * ($current_page - 1);
            }
            $query = "select count(*) as elem_count from tag";

            if ($result = $this->mysqli->query($query)) {

                /* извлечение ассоциативного массива */
                $row = $result->fetch_assoc();
            }
            $elem_count = $row['elem_count'];
            $pages_count = round($elem_count / $limit);

            $query = "select id, t_name from tag";
            $query .= " limit $start, $limit";

            if ($result = $this->mysqli->query($query)) {

                /* извлечение ассоциативного массива */
                while ($row = $result->fetch_assoc()) {

                    $tag_id = $row['id'];

                    $tags[$tag_id]['id'] = $row['id'];
                    $tags[$tag_id]['t_name'] = $row['t_name'];
                }
                /* удаление выборки */
                $result->free();
            }

        $return['tags'] = $tags;
        $return['pageCount'] = $pages_count;
        $return['currentPage'] = $current_page;
        return $return;
        }
    }