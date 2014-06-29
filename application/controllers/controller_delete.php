<?php

    class Controller_Delete extends Controller
    {

        function __construct()
        {
            $this->model = new Model_Delete();
            $this->view = new View();
        }

        function action_index()
        {
            $this->model->delete_data();
        }
    }