<?php

class Controller_Article extends Controller
{

    function __construct()
    {
        $this->model = new Model_Article();
        $this->view = new View();
    }

    function action_create()
    {
        $errors = $this->model->set_data();
        $this->view->generate('create_view.php', 'template_view.php', $errors);
    }

    function action_edit()
    {
        $data = $this->model->get_article();

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

                $this->model->update_article($validationResult['data'], $validationResult['tags']);
            }
            $data['errors'] = $validationResult['errors'];
        }

        $this->view->generate('edit_view.php', 'template_view.php', $data);


    }

    function action_delete()
    {
        $this->model->delete_data();

    }
}