<?php


class Single_class extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $class = new Classes_model;
        $data = $class->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if ($data) {
            $crumbs[] = [$data->class, 'class'];
        }
        $lect = new Lecturers_model();
        $results = false;
        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lecturers';
        if ($page_tab == 'lecturers-add' && count($_POST) > 0) {
            if (isset($_POST['search'])) {
                $user = new User();
                $name = '%' . trim($_POST['name']) . '%';
                $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'lecturer' limit 10";
                $results = $user->query($query, ['fname' => $name, 'lname' => $name]);
            } else {
                if (isset($_POST['selected'])) {
                    $arr = array();
                    $arr['class_id'] = $id;
                    $arr['user_id'] = $_POST['selected'];
                    $arr['disabled'] = 0;
                    $arr['date'] = date('Y-m-d H:i:s');
                    $lect->insert($arr);

                    $this->redirect('single_class/' . $id . '?tab=lecturers');
                }
            }
        } else {
            if ($page_tab == 'lecturers') {
                $lecturers = $lect->where('class_id', $id);
                $datas['lecturers'] = $lecturers;
            }
        }

        $datas['class'] = $data;
        $datas['crumbs'] = $crumbs;
        $datas['page_tab'] = $page_tab;
        $datas['results'] = $results;

        $this->view('single-class', $datas);
    }
}
