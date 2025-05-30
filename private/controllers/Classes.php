<?php


class Classes extends Controller
{

    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $classes = new Classes_model();
        $school_id =  Auth::getSchool_id();
        if (Auth::access(('admin'))) {
            $query = "select * from classes where school_id = :school_id && year(date) = :school_year order by date desc";
            $arr['school_id'] = $school_id;
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select * from classes where school_id = :school_id && (class like :find) && year(date) = :school_year order by date desc";
                $arr['find'] = $find;
            }
            $data =  $classes->query($query, $arr);
        } else {
            $my_table = "class_students";
            if (Auth::getRank() == 'lecturer') {
                $my_table = "class_lecturers";
            }
            // $query = "select * from $my_table where user_id = :user_id && disabled = 0";
            $query = "select * from classes where (class_id in (select class_id from $my_table where user_id = :user_id && disabled = 0) && year(date) = :school_year ) || user_id = :user_id && year(date) = :school_year order by date desc";
            $arr['user_id'] = Auth::getUser_id();
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "SELECT * FROM classes WHERE ((class_id IN (SELECT class_id FROM $my_table WHERE user_id = :user_id AND disabled = 0) AND class LIKE :find) OR (user_id = :user_id AND class LIKE :find)) ORDER BY date DESC";
                $arr['find'] = $find;
            }


            $data = $classes->query($query, $arr);

            // show($arr['stud_classes']);
            //680a54f67e2106tvl91JAE0O8hGMFRaqfNZHKV2rXCUxiTLmjpWbB

            //get ids from classes i own and classes i am in that doesnt have a member yet
            // $class_i_own = $class->where('user_id', Auth::getUser_id());
            // // show($class_i_own);

            // if ($class_i_own &&  $arr['stud_classes']) {
            //     $arr['stud_classes'] = array_merge($arr['stud_classes'], $class_i_own);
            // }

            // $data = array();
            // if ($arr['stud_classes']) {

            //     $all_classes = array_column($arr['stud_classes'], 'class_id');
            //     $all_classes = array_unique($all_classes);

            //     foreach ($all_classes as $class_id) {
            //         $data[] = $class->whereOne('class_id', $class_id);
            //     }
            // }
        }

        // show($data);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        $this->view('classes', ['classes' => $data, 'crumbs' => $crumbs]);
    }


    public function add()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }

        $errors = array();
        if (count($_POST) > 0 && Auth::access('lecturer')) {
            $classes = new Classes_model();
            if ($classes->validate($_POST)) {
                $_POST['date'] = date('Y-m-d H:i:s');
                $classes->insert($_POST);
                $this->redirect('classes');
            } else {
                $errors = $classes->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        $crumbs[] = ['Add', 'classes/add'];

        if (Auth::access('lecturer')) {
            $this->view('classes.add', ['errors' => $errors, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }

    public function edit($id = null)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $classes = new Classes_model();
        $row = $classes->where('id', $id);
        $errors = array();
        if (count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row)) {
            $classes = new Classes_model();
            if ($classes->validate($_POST)) {
                $classes->update($id, ($_POST));
                $this->redirect('classes');
            } else {
                $errors = $classes->errors;
            }
        }

        $classes = $classes->where('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['classes', 'classes'];
        $crumbs[] = ['Edit', 'classes/edit'];
        if (Auth::access('lecturer') && Auth::i_own_content($classes)) {
            $this->view('classes.edit', ['errors' => $errors, 'classes' => $classes, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }
    public function delete($id)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $classes = new Classes_model();
        $row = $classes->where('id', $id);
        $errors = array();
        if ($id && Auth::access('lecturer') && Auth::i_own_content($row)) {
            $classes->delete($id);
            $this->redirect('classes');
        } else {
            $errors = $classes->errors;
        }

        $classes = $classes->where('id', $id);

        if (Auth::access('lecturer') && Auth::i_own_content($classes)) {
            $this->view('classes.delete', ['errors' => $errors, 'classes' => $classes]);
        } else {
            $this->view('access-denied');
        }
    }
}
