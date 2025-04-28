<?php


class Profile extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $user = new User();
        $datas = $user->whereOne('user_id', $id);
        $rows = $user->whereOne('user_id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Users', 'users'];
        if ($datas) {
            $crumbs[] = [$datas->firstname, 'profile'];
        }
        //get more info depending on tab
        $data['page_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'info';

        if ($data['page_tab'] == 'classes' &&  $datas) {
            $class = new Classes_model();
            $my_table = "class_students";

            if ($datas->rank == 'lecturer') {
                $my_table = "class_lecturers";
            }

            $query = "select * from $my_table where user_id = :user_id && disabled = 0";

            $data['stud_classes'] = $class->query($query, ['user_id' => $id]);

            $data['student_classes'] = [];
            if (isset($data['stud_classes']) && !empty($data['stud_classes'])) {
                foreach ($data['stud_classes'] as $stud_class) {
                    $data['student_classes'][] = $class->whereOne('id', $stud_class->class_id);
                }
            }
        }

        $data['crumbs'] = $crumbs;
        $data['user'] = $datas;


        if (Auth::access('reception') || Auth::i_own_content($rows)) {
            $this->view('profile', $data);
        } else {
            $this->view('access-denied');
        }
    }
}
