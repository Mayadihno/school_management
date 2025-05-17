<?php


class Marked extends Controller
{

    public function index()
    {
        if (!Auth::access('lecturer')) {
            $this->redirect('access_denied');
        }

        $test = new Tests_model();
        $school_id =  Auth::getSchool_id();
        if (Auth::access(('admin'))) {
            $query = "select * from tests where school_id = :school_id && year(date) = :school_year order by date desc";
            $arr['school_id'] = $school_id;
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select * from tests where school_id = :school_id && (test like :find) && year(date) = :school_year order by date desc";
                $arr['find'] = $find;
            }
            $data =  $test->query($query, $arr);
        } else {
            $my_table = "class_lecturers";
            $query = "select * from $my_table where user_id = :user_id && disabled = 0 && year(date) = :school_year order by date desc";
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());
            $arr['user_id'] = Auth::getUser_id();
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select tests.test, {$my_table}.* from $my_table join tests on tests.test_id = {$my_table}.test_id where {$my_table}.user_id = :user_id && {$my_table}.disabled = 0 && tests.test like :find && year(tests.date) = :school_year";
                //$query = "select tests.test, {$mytable}.* from $mytable join tests on tests.test_id = {$mytable}.test_id where {$mytable}.user_id = :user_id && {$mytable}.disabled = 0 && tests.test like :find && year(tests.date) = :school_year";
                $arr['find'] = $find;
                $arr['find'] = $find;
            }

            $arr['stud_tests'] = $test->query($query, $arr);

            //read all test from selected classes
            $data = [];
            if (isset($arr['stud_tests']) && !empty($arr['stud_tests'])) {
                foreach ($arr['stud_tests'] as $stud_test) {
                    $query = "select * from tests where class_id = :class_id order by date desc";
                    $res = $test->query($query, ['class_id' => $stud_test->class_id]);
                    if (is_array($res) && count($res) > 0) {
                        $data = array_merge($data, $res);
                    }
                }
            }
            //get all submitted tests

        }

        $marked = [];
        if (isset($data) && !empty($data)) {
            $all_tests = array_column($data, 'id');
            $all_tests_string = "'" . implode("','", $all_tests) . "'";
            $query = "select * from answered_tests where test_id in ($all_tests_string) && submitted = 1 && marked = 1 order by date desc";
            $marked = $test->query($query);
            if (is_array($marked)) {
                foreach ($marked as $key => $value) {
                    $test_details = $test->whereOne('id', $marked[$key]->test_id);
                    $marked[$key]->test_details = $test_details;
                }
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Marked', 'marked'];
        $this->view('marked', ['marked' => $marked, 'crumbs' => $crumbs]);
    }
}
