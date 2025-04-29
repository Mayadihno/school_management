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

        $limit = 2;
        $pager = new Pager($limit);
        $offset = $pager->offset;


        $query = "select * from users where school_id = :school_id && rank not in ('student', 'super-admin') order by date desc limit $limit offset $offset";
        $arr['school_id'] = $school_id;
        if (isset($_GET['find'])) {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from users where school_id = :school_id && rank not in ('student', 'super-admin') && (firstname like :find || lastname like :find) order by date desc limit $limit offset $offset";
            $arr['find'] = $find;
        }
        $data = $user->query($query, $arr);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Users', 'users'];
        if (Auth::access('admin')) {
            $this->view('users', ['users' => $data, 'crumbs' => $crumbs, 'pager' => $pager]);
        } else {
            $this->view('access-denied');
        }
    }
}
