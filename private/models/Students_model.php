<?php

class Students_model extends Model
{

    protected $table = 'class_students';

    protected $allowedColumns = [
        'class_id',
        'user_id',
        'date',
        'disabled',
        'school_id'
    ];
    protected $beforeInsert = [
        'make_id',
        'make_school_id',
    ];
    protected $afterSelect = [
        'get_user',
    ];



    public function make_school_id($data)
    {
        if (isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id;
        }
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
