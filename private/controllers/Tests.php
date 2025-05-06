<?php


class Tests extends Controller
{

    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $tests = new Tests_model();
        $school_id =  Auth::getSchool_id();
        if (Auth::access(('admin'))) {
            $query = "select * from tests where school_id = :school_id order by date desc";
            $arr['school_id'] = $school_id;
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select * from tests where school_id = :school_id && (test like :find) order by date desc";
                $arr['find'] = $find;
            }
            $data =  $tests->query($query, $arr);
        } else {

            $test = new Tests_model();
            $my_table = "class_students";

            if (Auth::getRank() == 'lecturer') {
                $my_table = "class_lecturers";
            }

            $query = "select * from $my_table where user_id = :user_id && disabled = 0";

            $arr['user_id'] = Auth::getUser_id();
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select tests.test, {$my_table}.* from $my_table join tests on tests.id = {$my_table}.test_id where {$my_table}.user_id = :user_id && {$my_table}.disabled = 0 && tests.test like :find order by tests.date desc";
                $arr['find'] = $find;
            }

            $arr['stud_tests'] = $test->query($query, $arr);

            $data = [];
            if (isset($arr['stud_tests']) && !empty($arr['stud_tests'])) {
                foreach ($arr['stud_tests'] as $stud_test) {
                    $res = $test->where('class_id', $stud_test->class_id);
                    if (is_array($res) && count($res) > 0) {
                        $data = array_merge($data, $res);
                    }
                }
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        $this->view('tests', ['tests' => $data, 'crumbs' => $crumbs]);
    }


    public function add()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }

        $errors = array();
        if (count($_POST) > 0 && Auth::access('lecturer')) {
            $tests = new Tests_model();
            if ($tests->validate($_POST)) {
                $_POST['date'] = date('Y-m-d H:i:s');
                $tests->insert($_POST);
                $this->redirect('Tests');
            } else {
                $errors = $tests->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'Tests'];
        $crumbs[] = ['Add', 'Tests/add'];

        if (Auth::access('lecturer')) {
            $this->view('Tests.add', ['errors' => $errors, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }

    public function edit($id = null)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $Tests = new Tests_model();
        $row = $Tests->where('id', $id);
        $errors = array();
        if (count($_POST) > 0 && Auth::access('lecturer') && Auth::i_own_content($row)) {
            $Tests = new Tests_model();
            if ($Tests->validate($_POST)) {
                $Tests->update($id, ($_POST));
                $this->redirect('Tests');
            } else {
                $errors = $Tests->errors;
            }
        }

        $Tests = $Tests->where('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'Tests'];
        $crumbs[] = ['Edit', 'Tests/edit'];
        if (Auth::access('lecturer') && Auth::i_own_content($Tests)) {
            $this->view('Tests.edit', ['errors' => $errors, 'Tests' => $Tests, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }
    public function delete($id)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $Tests = new Tests_model();
        $row = $Tests->where('id', $id);
        $errors = array();
        if ($id && Auth::access('lecturer') && Auth::i_own_content($row)) {
            $Tests->delete($id);
            $this->redirect('Tests');
        } else {
            $errors = $Tests->errors;
        }

        $Tests = $Tests->where('id', $id);

        if (Auth::access('lecturer') && Auth::i_own_content($Tests)) {
            $this->view('Tests.delete', ['errors' => $errors, 'Tests' => $Tests]);
        } else {
            $this->view('access-denied');
        }
    }
}
