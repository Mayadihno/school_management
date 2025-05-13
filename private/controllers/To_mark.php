<?php


class To_mark extends Controller
{

    public function index()
    {
        if (!Auth::access('lecturer')) {
            $this->redirect('access_denied');
        }
        $test = new Tests_model();

        $school_id =  Auth::getSchool_id();
        if (Auth::access(('admin'))) {
            // $query = "select * from tests where school_id = :school_id order by date desc";
            $query = "select * from answered_tests where test_id in (select id from tests where school_id = :school_id) && submitted = 1 && marked = 0 order by date desc";

            $arr['school_id'] = $school_id;
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select * from tests where school_id = :school_id && (test like :find) order by date desc";
                $arr['find'] = $find;
            }
            $to_mark =  $test->query($query, $arr);
        } else {

            $my_table = "class_lecturers";
            // $query = "select * from $my_table where user_id = :user_id && disabled = 0";
            $arr['user_id'] = Auth::getUser_id();
            $query = "select * from answered_tests where test_id in (select id from tests where class_id in (SELECT class_id FROM class_lecturers WHERE user_id = :user_id)) && submitted = 1 && marked = 0 order by date desc";
            $to_mark = $test->query($query, $arr);

            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select tests.test, {$my_table}.* from $my_table join tests on tests.id = {$my_table}.test_id where {$my_table}.user_id = :user_id && {$my_table}.disabled = 0 && tests.test like :find order by tests.date desc";
                $arr['find'] = $find;
            }

            // $arr['stud_tests'] = $test->query($query, $arr);

            //read all test from selected classes
            // $data = [];
            // if (isset($arr['stud_tests']) && !empty($arr['stud_tests'])) {
            //     foreach ($arr['stud_tests'] as $stud_test) {
            //         $query = "select * from tests where class_id = :class_id order by date desc";
            //         $res = $test->query($query, ['class_id' => $stud_test->class_id]);
            //         if (is_array($res) && count($res) > 0) {
            //             $data = array_merge($data, $res);
            //         }
            //     }
            // }
        }

        //get all submitted tests
        // $to_mark = [];
        // if ($to_mark) {
        //     foreach ($data as $stud_test) {
        //         $query = "select * from answered_tests where test_id = :test_id && submitted = 1 && marked = 0 order by date desc";
        //         $res = $test->query($query, ['test_id' => $stud_test->id]);
        //         if (is_array($res) && count($res) > 0) {
        //             $test_details = $test->whereOne('id', $res[0]->test_id);
        //             $res[0]->test_details = $test_details;
        //             $to_mark = array_merge($to_mark, $res);
        //         }
        //     }
        // }

        if ($to_mark) {
            foreach ($to_mark as $key => $value) {
                $test_details = $test->whereOne('id', $value->test_id);
                if ($test_details) {
                    $to_mark[$key]->test_details = $test_details;
                }
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['To Mark', 'to_mark'];
        $this->view('to-mark', ['to_mark' => $to_mark, 'crumbs' => $crumbs]);
    }
}
