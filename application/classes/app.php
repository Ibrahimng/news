<?php

class App {

    public static function pr($var, $var_dump = 0)
    {
        echo "<pre>";
        if ($var_dump)
            var_dump($var);
        else
            print_r($var);
        die();
    }
}