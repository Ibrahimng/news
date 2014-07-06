<?php

class Controller_Main extends Controller
{

    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_indexh()
    {
        $data = $this->model->get_data(1);
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_tag()
    {
        if (isset($_GET['tag']))
            $data = $this->model->get_data_by_tag();
        else
            $data = $this->model->get_data();

        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
}