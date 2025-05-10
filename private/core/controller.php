<?php

class Controller
{
    public function view($view, $data = [])
    {

        extract($data);
        if (file_exists(__DIR__ . '/../views/' . $view . '.view.php')) {
            require __DIR__ . '/../views/' . $view . '.view.php';
        } else {
            require __DIR__ . '/../views/notFound.view.php';
        }
    }

    public function load_model($model_name)
    {
        if (file_exists(__DIR__ . '/../models/' . ucfirst($model_name) . '.php')) {
            require __DIR__ . '/../models/' . ucfirst($model_name) . '.php';
            return new $model_name();
        }

        return false;
    }

    public function redirect($link)
    {
        header("Location: " . ROOT . trim($link, '/'));
        die;
    }

    public function get_controller_name()
    {
        return strtolower($this::class);
    }
}
