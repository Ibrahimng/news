<?php

    class Controller_Tag extends Controller
    {

        function __construct()
        {
            $this->model = new Model_Tag();
            $this->view = new View();
        }

        function action_index()
        {
            $data = $this->model->get_tags();
            $this->view->generate('tag_view.php','template_view.php', $data);
        }

        function action_create()
        {
            $errors = $this->model->set_data();
            $this->view->generate('create_tag_view.php', 'template_view.php', $errors);
        }

        function action_edit()
        {
            $data = $this->model->get_tag();

            $data['errors'] = array();

            if (isset($_POST['save'])) {

                $validationResult = $this->model->validate(array(
                    'post'  => $_POST
                ));

                //записываю в БД
                if (!$validationResult['error']) {

                    $this->model->update_tag($validationResult['data']);
                }
                $data['errors'] = $validationResult['errors'];
            }

            $this->view->generate('edit_tag_view.php', 'template_view.php', $data);


        }

        function action_delete()
        {
            $this->model->delete_data();

        }
    }