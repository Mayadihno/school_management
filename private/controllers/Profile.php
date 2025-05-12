<?php


class Profile extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $user = new User();
        $test = new Tests_model();
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
                    $data['student_classes'][] = $class->whereOne('class_id', $stud_class->class_id);
                }
            }
        } else  if ($data['page_tab'] == 'tests' &&  $datas) {
            if ($datas->rank != 'student') {
                $class = new Classes_model();
                $my_table = "class_students";
                $disabled = '&& disabled = 0';

                if ($datas->rank == 'lecturer') {
                    $my_table = "class_lecturers";
                    $disabled = '';
                }

                $query = "select * from $my_table where user_id = :user_id && disabled = 0";

                $data['stud_classes'] = $class->query($query, ['user_id' => $id]);

                $data['student_classes'] = [];
                if (isset($data['stud_classes']) && !empty($data['stud_classes'])) {
                    foreach ($data['stud_classes'] as $stud_class) {
                        $data['student_classes'][] = $class->whereOne('id', $stud_class->class_id);
                    }
                }
                // show($data['student_classes']);
                $class_ids = [];
                foreach ($data['student_classes'] as $stud_class) {
                    $class_ids[] = $stud_class->id;
                }
                $id_string = "'" . implode("','", $class_ids) . "'";
                $query = "select * from tests where class_id in ($id_string) $disabled order by date desc";
                $test_model = new Tests_model();
                $tests = $test_model->query($query, []);
                $data['tests'] = $tests;
            } else {
                $marked = [];

                $query = "select * from answered_tests where user_id = :user_id && submitted = 1 && marked = 1 order by date desc";
                $res = $test->query($query, ['user_id' => $id]);

                if (is_array($res) && count($res) > 0) {
                    foreach ($res as $key => $value) {
                        $test_details = $test->whereOne('id', $res[$key]->test_id);
                        $res[$key]->test_details = $test_details;
                    }
                }
                $data['marked'] =  $res;
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
    public function edit($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $user = new User();
        $id =  trim($id == '') ? Auth::getUser_id() : $id;


        if (count($_POST) > 0) {
            if ($user->validate($_POST, $id)) {
                $user->hash_password($_POST);
                unset($_POST['password']);
                unset($_POST['confirm-password']);


                $myImage = upload_images($_FILES);
                if ($myImage) {
                    $_POST['image'] = $myImage;
                } else {
                    unset($_POST['image']);
                }

                $myRow = $user->whereOne('user_id', $id);

                if ($_POST['rank'] == 'super-admin' && $_SESSION['USER']->rank != 'super-admin') {
                    $_POST['rank'] = 'admin';
                }

                if (is_object($myRow)) {
                    $user->update($myRow->id, $_POST);
                    $this->redirect('profile/' . $id);
                }
            } else {
                // Validation failed
                $errors = $user->errors;
                // show($errors); // 🔍 Show validation errors
            }
        }

        $data = $user->whereOne('user_id', $id);
        $data = ['user' => $data];
        $data['errors'] = $errors;



        if (Auth::myProfile($data) || Auth::access('admin')) {
            $this->view('profile-edit', $data);
        } else {
            $this->view('access-denied');
        }
    }
}
