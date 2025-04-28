<?php


class Users extends Controller
{
    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $user = new User();
        $school_id =  Auth::getSchool_id();


        $query = "select * from users where school_id = :school_id && rank not in ('student') order by date desc";
        $arr['school_id'] = $school_id;
        if (isset($_GET['find'])) {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from users where school_id = :school_id && rank not in ('student') && (firstname like :find || lastname like :find) order by date desc";
            $arr['find'] = $find;
        }
        $data = $user->query($query, $arr);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Users', 'users'];
        if (Auth::access('admin')) {
            $this->view('users', ['users' => $data, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }
}
