<?php

require 'config.php';
require 'database.php';
require 'controller.php';
require 'model.php';
require 'app.php';


spl_autoload_register(function ($class_name) {

    require __DIR__ . '/../models/' . $class_name . '.php';
});
