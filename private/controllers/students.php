<?php


class Students extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $user = new User();
        $school_id =  Auth::getSchool_id();
        $query = "select * from users where school_id = :school_id && rank in ('student') order by date desc";
        $arr['school_id'] = $school_id;
        if (isset($_GET['find'])) {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from users where school_id = :school_id && rank in ('student') && (firstname like :find || lastname like :find) order by date desc";
            $arr['find'] = $find;
        }
        $data = $user->query($query, $arr);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Students', 'students'];
        if (Auth::access('reception')) {
            $this->view('students', ['students' => $data, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }
}
