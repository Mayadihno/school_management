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
        $data = $user->query("select * from users where school_id = :school_id && rank in ('student') order by date desc", ['school_id' => $school_id]);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Students', 'students'];
        $this->view('students', ['students' => $data, 'crumbs' => $crumbs]);
    }
}
