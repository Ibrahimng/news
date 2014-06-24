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
        $errors = $this->model->set_data();
        $this->view->generate('create_view.php', 'template_view.php', $errors);


    }
}