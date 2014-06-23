<?php

class Controller_Create extends Controller
{

    function __construct()
    {
        $this->model = new Model_Create();
        $this->view = new View();
    }

    function action_index()
    {
        $this->model->set_data();
        $this->view->generate('create_view.php', 'template_view.php');


    }
}