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
        $data = $user->query("select * from users where school_id = :school_id", ['school_id' => $school_id]);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Users', 'users'];
        $this->view('users', ['users' => $data, 'crumbs' => $crumbs]);
    }
}
