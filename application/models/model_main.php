<?php

class Model_Main extends Model
{
    public function get_data($active)
    {
        $return = array();
        $articles = array();

        $query = "select article.id, a_date, a_title, a_text, a_filepath, a_hidden, tag.id as tag_id, tag.t_name from article left join at_dict on article.id = at_dict.article_id  left join tag on at_dict.tag_id = tag.id";

        if ($active)
            $query .= " where a_hidden=0";
        else
            $query .= " where a_hidden=1";

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

    public function get_data_by_tag($active)
    {
        $articles = array();
        $in_clause = "";

        $tag_id = (int)mysql_real_escape_string($_GET['tag']);

        $query = "select article.id, a_date, a_title, a_text, a_filepath, a_hidden from article left join at_dict on article.id = at_dict.article_id left join tag on at_dict.tag_id = tag.id where tag.id=$tag_id";

        if ($active)
            $query .= " and article.a_hidden=0";
        else
            $query .= " and article.a_hidden=1";

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
            while ($row = $result->fetch_assoc()) {

                $article_id = $row['id'];
                $articles[$article_id]['id'] = $row['id'];
                $articles[$article_id]['a_title'] = $row['a_title'];
                $articles[$article_id]['a_text'] = $row['a_text'];
                $articles[$article_id]['a_date'] = $row['a_date'];
                $articles[$article_id]['a_filepath'] = $row['a_filepath'];
                $articles[$article_id]['a_hidden'] = $row['a_hidden'];

                $in_clause .= $row['id'] . ",";
            }
            /* удаление выборки */
            $result->free();
        }

        App::array_log($articles);

        $clause_length = strlen($in_clause);
        if ($clause_length > 0) {
            $in_clause = " where article_id in (" . substr($in_clause, 0, $clause_length - 1) . ")";
        }

        $query = "select article_id as ai, tag_id as ti, t_name as tn from at_dict at left join tag t on at.tag_id = t.id" . $in_clause;

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
            while ($row = $result->fetch_assoc()) {

                $articles[$row['ai']]['tags'][] = array('t_id' => $row['ti'],
                                                            't_name' => $row['tn']);
            }
            /* удаление выборки */
            $result->free();
        }


//        echo "<pre>";
//        print_r($articles);
//        die();
        //-------------------------------------------------------

        return $articles;
    }
}