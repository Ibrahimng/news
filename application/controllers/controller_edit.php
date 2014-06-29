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
            $data = $this->model->get_article();
;
//            echo "<pre>";
//            var_dump($data);
//            echo "</pre>";

            $data['errors'] = array();

            if (isset($_POST['save'])) {

                $validationResult = $this->model->validate(array(
                    'post'  => $_POST,
                    'files' => $_FILES
                ));

//                echo "<pre>";
//var_dump($validationResult);
//die();

                //записываю в БД
                if (!$validationResult['error']) {

                    $this->model->update_article($validationResult['data']);
                }
                $data['errors'] = $validationResult['errors'];
            }

            $this->view->generate('edit_view.php', 'template_view.php', $data);


        }

    }