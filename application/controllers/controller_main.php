<?php

class Controller_Main extends Controller
{


    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function renderNews($active)
    {
        $data = $this->model->get_data($active);
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function renderNewsByTag($active)
    {
        if (isset($_GET['tag']))
            $data = $this->model->get_data_by_tag($active);
        else
            $data = $this->model->get_data($active);

        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_index()
    {
        $active = 1;
        if (isset($_GET['active']))
            if ($_GET['active'] == '0')
                $active = 0;

        if (isset($_GET['type']))
            if ($_GET['type'] == 'tag')
                self::renderNewsByTag($active);
            else
                self::renderNews($active);
        else
            self::renderNews($active);
    }

}