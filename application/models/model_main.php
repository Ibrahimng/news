<?php

class Model_Main extends Model
{
    public function get_data()
    {



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



        $return = array();
        $articles = array();
        $tags = array();

        $query = "select article.id, a_date, a_title, a_text, a_filepath, a_hidden, tag.id as tag_id, tag.t_name from article left join at_dict on article.id = at_dict.article_id  left join tag on at_dict.tag_id = tag.id";

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
            while ($row = $result->fetch_assoc()) {
                $article_id = $row['id'];
                if (!in_array($article_id, $articles)) {

                    $articles[$article_id]['id'] = $row['id'];
                    $articles[$article_id]['a_title'] = $row['a_title'];
                    $articles[$article_id]['a_text'] = $row['a_text'];
                    $articles[$article_id]['a_date'] = $row['a_date'];
                    $articles[$article_id]['a_filepath'] = $row['a_filepath'];
                    $articles[$article_id]['a_hidden'] = $row['a_hidden'];
                }
                array_push($return, $row);
            }
            /* удаление выборки */
            $result->free();
        }


        foreach ($return as $row) {
            $articles[$row['id']]['tags'][] = array('t_id' => $row['tag_id'],
                                        't_name' => $row['t_name']);
        }

//        echo "<pre>";
//        print_r($articles);
//        die();


        //-------------------------------------------------------

        return $articles;
    }
}