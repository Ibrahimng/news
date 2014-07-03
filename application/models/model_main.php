<?php

class Model_Main extends Model
{
    public function get_data()
    {
        $return = array();
        $articles = array();

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

        if (isset($_GET['tag'])) {
            $tag_id = (int)mysql_real_escape_string($_GET['tag']);
            foreach ($articles as $article)
            {
                $id = $article['id'];

                $find_tag = 0;
                foreach ($article['tags'] as $tag)
                {
                    if ($tag_id == $tag['t_id'])
                    {
                        $find_tag = 1;
                        break;
                    }
                }
                if (!$find_tag)
                    unset($articles[$id]);
            }
        }

//        echo "<pre>";
//        print_r($articles);
//        die();


        //-------------------------------------------------------

        return $articles;
    }
}