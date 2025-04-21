<?php


class Auth
{
    public static function authenticate($user)
    {
        $_SESSION['USER'] = $user;
    }

    public static function logout()
    {
        if (isset($_SESSION['USER'])) {
            unset($_SESSION['USER']);
        }
    }

    public static function authenticated()
    {
        if (isset($_SESSION['USER'])) {
            return true;
        }
        return false;
    }
    public static function user()
    {
        if (isset($_SESSION['USER'])) {
            return $_SESSION['USER']->firstname;
        }
        return false;
    }

    public static function __callStatic($name, $arguments)
    {
        $prop = strtolower(str_replace('get', '', $name));
        if (isset($_SESSION['USER']->$prop)) {
            return $_SESSION['USER']->$prop;
        }
        return 'Unknown';
    }
}
