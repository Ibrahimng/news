<?php

class Controller_Edit extends Controller
{

    function __construct()
    {
        $this->model = new Model_Edit();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_atricle();

        $data['errors'] = array();

        if (isset($_POST['save'])) {

            $info = "";

            $validationResult = $this->model->validate(array(
                'post'  => $_POST,
                'files' => $_FILES
            ));

            //записываю в БД
            if (!$validationResult['error']) {
//                $validationResult['data'] = array_map(function($v) {
//                    return "'" . str_replace("'", '"', $v) . "'";
//                }, $validationResult['data']);

            $atitle = $validationResult['data']['a_title'];
            $atext = $validationResult['data']['a_text'];
            $adate = $validationResult['data']['a_date'];
            $aid = $validationResult['data']['a_id'];

                $q = "update article set a_title=$atitle, a_text=$atext , a_date=$adate where id=$aid";
                echo "<pre>";
                var_dump($q);
                die();
                $this->mysqli->query($q);
                if ($this->mysqli->errno) {
                    $info .= 'Select Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error;
                }
                header ("Location: /");
            }
            $data['errors'] = $validationResult['errors'];
        }

        $this->view->generate('edit_view.php', 'template_view.php', $data);


    }

}