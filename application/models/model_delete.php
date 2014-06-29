<?php

    class Model_Delete extends Model
    {
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