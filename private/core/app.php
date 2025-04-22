<?php

class App
{

    private $controller = 'home';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        $URL = $this->getURL();

        // Default controller name
        $this->controller = 'home';

        // If a valid controller is passed via URL
        if (isset($URL[0]) && file_exists(__DIR__ . '/../controllers/' . $URL[0] . '.php')) {
            $this->controller = ucfirst($URL[0]);
            unset($URL[0]);
        }

        $controllerPath = __DIR__ . '/../controllers/' . $this->controller . '.php';
        require $controllerPath;

        // Instantiate the controller
        $this->controller = new $this->controller();


        if (isset($URL[1])) {
            if (method_exists($this->controller, $URL[1])) {
                $this->method =  ucfirst($URL[1]);
                unset($URL[1]);
            }
        };

        $URL = array_values($URL);
        $this->params = $URL;

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function getURL()

    {
        return isset($_GET['url']) ? explode('/', filter_var(trim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : ['home'];
        // Assuming URL is passed as a query parameter, e.g., ?url=controller/method/param1/param2
    }
}
