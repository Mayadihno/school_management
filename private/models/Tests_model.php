<?php

class Tests_model extends Model
{

    protected $table = 'tests';

    protected $allowedColumns = [
        'test',
        'date',
        'class_id',
        'description',
        'disabled',
    ];
    protected $beforeInsert = [
        'make_user_id',
        'make_id',
        'make_school_id',
        'make_test_id',
    ];
    protected $afterSelect = [
        'get_user',
        'get_class',
    ];

    public function validate($data)
    {
        $this->errors = array();
        if (empty($data['test']) || !preg_match('/^[A-Z a-z 0-9]+$/', $data['test'])) {
            $this->errors['test'] = "Test name can only contain letters and numbers";
        }
        if (count($this->errors) == 0) {
            return true;
        }
        return false;
    }
    public function make_user_id($data)
    {
        if (isset($_SESSION['USER']->user_id)) {
            $data['user_id'] = $_SESSION['USER']->user_id;
        }
        return $data;
    }
    public function make_school_id($data)
    {
        if (isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id;
        }
        return $data;
    }
    public function make_test_id($data)
    {

        $data['test_id'] =  make_uniqueid();
        return $data;
    }
    public function make_id($data)
    {

        $data['id'] =  make_uniqueid();
        return $data;
    }

    public function get_user($data)
    {
        $user = new User();
        foreach ($data as $key => $value) {
            $result = $user->where('user_id', $value->user_id);
            $data[$key]->user = is_array($result) ? $result[0] : false;
            //we are setting the new data key to user to accomadate the new value
        }
        return $data;
    }
    public function get_class($data)
    {
        $class = new Classes_model();
        foreach ($data as $key => $value) {
            if (isset($value->class_id)) {
                $result = $class->where('class_id', $value->class_id);
                $data[$key]->class = is_array($result) ? $result[0] : false;
            }
            //we are setting the new data key to class to accomadate the new value
        }
        return $data;
    }
    public function get_answered_test($test_id, $user_id)
    {

        $db = new Database();
        $arr = ['test_id' => $test_id, 'user_id' => $user_id];

        $query = "select * from answered_tests where test_id = :test_id && user_id = :user_id limit 1";

        $res = $db->query($query, $arr);


        if (is_array($res)) {
            return $res[0];
        }
        return false;
    }
    public function get_to_mark_count()
    {
        $school_id =  Auth::getSchool_id();
        if (Auth::access(('admin'))) {
            $query = "select * from tests where school_id = :school_id order by date desc";
            $arr['school_id'] = $school_id;
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select * from tests where school_id = :school_id && (test like :find) order by date desc";
                $arr['find'] = $find;
            }
            $data =  $this->query($query, $arr);
        } else {

            $my_table = "class_lecturers";
            $query = "select * from $my_table where user_id = :user_id && disabled = 0";

            $arr['user_id'] = Auth::getUser_id();
            if (isset($_GET['find'])) {
                $find = '%' . $_GET['find'] . '%';
                $query = "select tests.test, {$my_table}.* from $my_table join tests on tests.id = {$my_table}.test_id where {$my_table}.user_id = :user_id && {$my_table}.disabled = 0 && tests.test like :find order by tests.date desc";
                $arr['find'] = $find;
            }

            $arr['stud_tests'] = $this->query($query, $arr);

            //read all test from selected classes
            $data = [];
            if (isset($arr['stud_tests']) && !empty($arr['stud_tests'])) {
                foreach ($arr['stud_tests'] as $stud_test) {
                    $query = "select * from tests where class_id = :class_id order by date desc";
                    $res = $this->query($query, ['class_id' => $stud_test->class_id]);
                    if (is_array($res) && count($res) > 0) {
                        $data = array_merge($data, $res);
                    }
                }
            }
        }

        //get all submitted tests
        $to_mark = [];
        if (count($data) > 0) {
            foreach ($data as $stud_test) {
                $query = "select * from answered_tests where test_id = :test_id && submitted = 1 && marked = 0 order by date desc";
                $res = $this->query($query, ['test_id' => $stud_test->id]);
                if (is_array($res) && count($res) > 0) {
                    $test_details = $this->whereOne('id', $res[0]->test_id);
                    $res[0]->test_details = $test_details;
                    $to_mark = array_merge($to_mark, $res);
                }
            }
        }
        return count($to_mark);
    }
}
