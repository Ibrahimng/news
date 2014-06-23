<?php

class Model_Main extends Model
{
    public function get_data()
    {
        $articles = array();
        $query = "SELECT * FROM article";

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
            while ($row = $result->fetch_assoc()) {
                array_push($articles, $row);
            }
            /* удаление выборки */
            $result->free();
        }
        return $articles;
    }
}