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
    public static function switch_school($id)
    {
        if (isset($_SESSION['USER']) && $_SESSION['USER']->rank == 'super-admin') {
            $user = new User();
            $school = new School();
            $row = $school->where('id', $id);
            if ($row) {
                $row = $row[0];
                $arr['school_id'] = $row->school_id;
                $arr['school_name'] = $row->school;
                $user->update($_SESSION['USER']->id, $arr);
                $_SESSION['USER']->school_id = $row->school_id;
                $_SESSION['USER']->school_name = $row->school;
            }
            return true;
        }
        return false;
    }
    public static function access($rank = 'student')
    {
        if (!isset($_SESSION['USER'])) {
            return false;
        }

        $logged_in_user = $_SESSION['USER']->rank;

        $RANK['super-admin'] = ['super-admin', 'admin', 'lecturer', 'reception', 'student'];
        $RANK['admin'] = ['admin', 'lecturer', 'reception', 'student'];
        $RANK['lecturer'] = ['lecturer', 'reception', 'student'];
        $RANK['reception'] = ['reception', 'student'];
        $RANK['student'] = ['student'];

        if (!isset($RANK[$logged_in_user])) {
            return false;
        }

        if (in_array($rank, $RANK[$logged_in_user])) {
            return true;
        }
        return false;
    }

    public static function i_own_content($row)
    {
        if (!isset($_SESSION['USER'])) {
            return false;
        }

        if (isset($row->user_id)) {
            if ($_SESSION['USER']->user_id == $row->user_id) {
                return true;
            }
        }
        $allowed_rank[] = 'super-admin';
        $allowed_rank[] = 'admin';
        if (in_array($_SESSION['USER']->rank, $allowed_rank)) {
            return true;
        }
        return false;
    }
    public static function myProfile($row)
    {
        if (!isset($_SESSION['USER'])) {
            return false;
        }

        if (isset($row->user_id)) {
            if ($_SESSION['USER']->user_id == $row->user_id) {
                return true;
            }
        }

        return false;
    }
}
