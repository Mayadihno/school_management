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

        $limit = 10;
        $pager = new Pager($limit);
        $offset = $pager->offset;


        $query = "select * from users where school_id = :school_id && rank in ('student') order by date desc limit $limit offset $offset";
        $arr['school_id'] = $school_id;


        if (isset($_GET['find'])) {
            $find = '%' . $_GET['find'] . '%';
            $query = "select * from users where school_id = :school_id && rank in ('student') && (firstname like :find || lastname like :find) order by date desc limit $limit offset $offset";
            $arr['find'] = $find;
        }
        $data = $user->query($query, $arr);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Students', 'students'];
        if (Auth::access('reception')) {
            $this->view('students', ['students' => $data, 'crumbs' => $crumbs, 'pager' => $pager]);
        } else {
            $this->view('access-denied');
        }
    }
}
