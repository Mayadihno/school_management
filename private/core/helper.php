<?php

function get_value($key)
{
    if (isset($_POST[$key])) {
        return $_POST[$key];
    }
    return '';
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
