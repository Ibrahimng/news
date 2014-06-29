<?php

class Model_Main extends Model
{
    public function get_data()
    {
        $return = array(
            'visible'  => array(),
            'hidden'   => array(),
        );
        $query = "select * from article where a_hidden=0 order by id desc";

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
            while ($row = $result->fetch_assoc()) {
                array_push($return['visible'], $row);
            }
            /* удаление выборки */
            $result->free();
        }

        $query = "select * from article where a_hidden=1 order by id desc";

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
            while ($row = $result->fetch_assoc()) {
                array_push($return['hidden'], $row);
            }
            /* удаление выборки */
            $result->free();
        }

        return $return;
    }
}