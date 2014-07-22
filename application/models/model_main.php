<?php

class Model_Main extends Model
{
    public function get_data($active)
    {
        $return = array(
            'articles' => array(),
            'pagesCount' => 1,
            'currentPage' => 1,
            'active' => 1,
            'type' => ''
        );
        $articles = array();
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
        $query = "select count(*) as elem_count from article";

        if ($active)
        {
            $query .= " where a_hidden=0";
        }
        else
        {
            $return['active'] = 0;
            $query .= " where a_hidden=1";
        }

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
        $row = $result->fetch_assoc();
        }
        $elem_count = $row['elem_count'];
        $pages_count = round($elem_count / $limit);

//
//        $query = "select article.id, a_date, a_title, a_text, a_filepath, a_hidden, tag.id as tag_id, tag.t_name from article left join at_dict on article.id = at_dict.article_id  left join tag on at_dict.tag_id = tag.id";
        $query = "select article.id, a_date, a_title, a_text, a_filepath, a_hidden from article";

        if ($active)
            $query .= " where a_hidden=0";
        else
            $query .= " where a_hidden=1";

        $query .= " limit $start, $limit";


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

        $clause_length = strlen($in_clause);
        if ($clause_length > 0) {
            $in_clause = " where article_id in (" . substr($in_clause, 0, $clause_length - 1) . ")";


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
        }

//        foreach ($return as $row) {
//            $articles[$row['id']]['tags'][] = array('t_id' => $row['tag_id'],
//                                        't_name' => $row['t_name']);
//        }

//        echo "<pre>";
//        print_r($articles);
//        die();


        //-------------------------------------------------------

        $return['articles'] = $articles;
        $return['pageCount'] = $pages_count;
        $return['currentPage'] = $current_page;
        return $return;
    }

    public function get_data_by_tag($active)
    {
//        App::pr("test");
        $return = array(
            'articles' => array(),
            'pagesCount' => 1,
            'currentPage' => 1,
            'active' => 1,
            'type' => '',
            'tag' => ''
        );
        $articles = array();
        $in_clause = "";

        $start = 0;
        $limit = 2;
        $current_page = 1;
        $articles = array();

        if (isset($_GET['page']))
        {
            $current_page = $_GET['page'];
            if ($current_page > 1)
                $start += $limit * ($current_page - 1);
        }

        $tag_id = (int)mysql_real_escape_string($_GET['tag']);


        $query = "select count(*) as elem_count from article left join at_dict on article.id = at_dict.article_id left join tag on at_dict.tag_id = tag.id where tag.id=$tag_id";

        if ($active)
        {
            $query .= " and a_hidden=0";
        }
        else
        {
            $return['active'] = 0;
            $query .= " and a_hidden=1";
        }

        if ($result = $this->mysqli->query($query)) {

            /* извлечение ассоциативного массива */
            $row = $result->fetch_assoc();
        }
        $elem_count = $row['elem_count'];
        $pages_count = round($elem_count / $limit);






        $query = "select article.id, a_date, a_title, a_text, a_filepath, a_hidden from article left join at_dict on article.id = at_dict.article_id left join tag on at_dict.tag_id = tag.id where tag.id=$tag_id";

        if ($active)
            $query .= " and article.a_hidden=0";
        else
            $query .= " and article.a_hidden=1";

        $query .= " limit $start, $limit";

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
        $return['tag'] = $tag_id;
        $return['type'] = 'tag';
        $return['articles'] = $articles;
        $return['pageCount'] = $pages_count;
        $return['currentPage'] = $current_page;
        return $return;
    }
}