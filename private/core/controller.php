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
}
