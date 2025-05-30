<?php


class Tests extends Controller
{

    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $test = new Tests_model();
        $school_id =  Auth::getSchool_id();
        if (Auth::access(('admin'))) {
            $query = "select * from tests where school_id = :school_id && year(date) = :school_year  order by date desc";
            $arr['school_id'] = $school_id;
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select * from tests where school_id = :school_id && (test like :find) && year(date) = :school_year  order by date desc";
                $arr['find'] = $find;
            }
            $data =  $test->query($query, $arr);
        } else {
            $my_table = "class_students";
            $disabled = '&& disabled = 0';

            if (Auth::getRank() == 'lecturer') {
                $my_table = "class_lecturers";
                $disabled = '';
            }

            $query = "select * from tests where (class_id in (select class_id from $my_table where user_id = :user_id $disabled) $disabled && year(date) = :school_year) || user_id = :user_id && year(date) = :school_year order by date desc";
            $arr['user_id'] = Auth::getUser_id();
            $arr['school_year'] = !empty($_SESSION['SCHOOL_YEAR']->year) ? $_SESSION['SCHOOL_YEAR']->year : date("Y", time());
            $data = $test->query($query, $arr);

            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select * from tests where class_id in (select class_id from $my_table where user_id = :user_id $disabled) $disabled && (test like :find) && year(date) = :school_year  order by date desc";
                $arr['find'] = $find;
            }
            $data = $test->query($query, $arr);



            // $data = [];
            // $arr2 = [];
            // if (isset($arr['stud_tests']) && !empty($arr['stud_tests'])) {
            //     foreach ($arr['stud_tests'] as $stud_test) {
            //         $query = "select * from tests where class_id = :class_id $disabled order by date desc";
            //         $arr2['class_id'] = $stud_test->class_id;

            //         if (isset($_GET['find'])) {
            //             $find = '%' . $_GET['find'] . '%';
            //             $query = "select * from tests where class_id = :class_id $disabled && (test like :find) order by date desc";
            //             $arr2['find'] = $find;
            //         }

            //         $res = $test->query($query, $arr2);
            //         if (is_array($res) && count($res) > 0) {
            //             $data = array_merge($data, $res);
            //         }
            //     }
            // }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        $this->view('tests', [
            'tests' => $data,
            'crumbs' => $crumbs,
            'unsubmitted' => get_unsubmitted_test_rows()
        ]);
    }
}
