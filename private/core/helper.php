<?php

function get_value($key, $default = '')
{
    if (isset($_POST[$key])) {
        return $_POST[$key];
    }
    return $default;
}

function get_select($key, $value)
{
    if (isset($_POST[$key]) && $_POST[$key] == $value) {
        return 'selected';
    }
    return '';
}

function esc($val)
{
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

function make_uniqueid()
{
    $uniq = uniqid('', true);
    $cleaned = str_replace('.', '', $uniq);
    $base = substr($cleaned, 0, 13);
    $random = substr(str_shuffle(RANDOM), 0, 40);
    $text = $base . $random;
    return $text;
}


function get_date($date,)
{
    return date("jS M, Y", strtotime($date));
}


function show($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}


function get_image($image, $gender = '')
{
    if (!file_exists($image)) {
        $image = ASSETS . 'female-icon.jpg';
        if ($gender == 'male') {
            $image = ASSETS . 'male-icon.png';
        }
    } else {
        $class_image = new Image();
        $image = ROOT . $class_image->profile_thumbnail($image);
    }
    return $image;
}


function view_path($view)
{
    if (file_exists(__DIR__ . '/../views/' . $view . '.inc.php')) {
        return __DIR__ . '/../views/' . $view . '.inc.php';
    } else {
        return __DIR__ . '/../views/notFound.view.php';
    }
}
