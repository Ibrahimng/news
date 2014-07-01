<?php

class Model_Main extends Model
{
    public function get_data()
    {




        $return = array(
            'visible'  => array(),
            'hidden'   => array(),
            'tags' => array()
        );
//        $query = "select * from article where a_hidden=0 order by id desc";
//
//        if ($result = $this->mysqli->query($query)) {
//
//            /* извлечение ассоциативного массива */
//            while ($row = $result->fetch_assoc()) {
//                array_push($return['visible'], $row);
//            }
//            /* удаление выборки */
//            $result->free();
//        }
//
//        $query = "select * from article where a_hidden=1 order by id desc";
//
//        if ($result = $this->mysqli->query($query)) {
//
//            /* извлечение ассоциативного массива */
//            while ($row = $result->fetch_assoc()) {
//                array_push($return['hidden'], $row);
//            }
//            /* удаление выборки */
//            $result->free();
//        }

        //---------------вывод с тегами--------------------------

        $query = "select article.id, a_date, a_title, a_text, a_filepath, a_hidden, tag.id as tag_id, tag.t_name from article left join at_dict on article.id = at_dict.article_id  left join tag on at_dict.tag_id = tag.id";

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
            while ($row = $result->fetch_assoc()) {
                array_push($return['visible'], $row);
            }
            /* удаление выборки */
            $result->free();
        }

        $tags = array();
        foreach ($return['visible'] as $row) {
            $tags[$row['id']][] = array('t_id' => $row['tag_id'],
                                        't_name' => $row['t_name']);
        }

//        echo "<pre>";
//        print_r($return['visible']);
//        print_r($tags);
//        die();

        $return['tags'] = $tags;

        //-------------------------------------------------------

        return $return;
    }
}