<?php

class Classes_model extends Model
{

    protected $table = 'classes';

    protected $allowedColumns = [
        'class',
        'date',
    ];
    protected $beforeInsert = [
        'make_user_id',
        'make_class_id',
        'make_id',
        'make_school_id',
    ];
    protected $afterSelect = [
        'get_user',
    ];

    public function validate($data)
    {
        $this->errors = array();
        if (empty($data['class']) || !preg_match('/^[A-Z a-z 0-9]+$/', $data['class'])) {
            $this->errors['class'] = "class name can only contain letters and numbers";
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
    public function make_class_id($data)
    {

        $data['class_id'] =  make_uniqueid();
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
}
