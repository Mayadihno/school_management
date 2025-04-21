<?php

class School extends Model
{
    protected $allowedColumns = [
        'school',
        'date',
    ];
    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password',
    ];

    public function validate($data)
    {
        $this->errors = array();
        if (empty($data['school']) || !preg_match('/^[A-Za-z]+$/', $data['school'])) {
            $this->errors['school'] = "School name can only contain letters";
        }
        if (count($this->errors) == 0) {
            return true;
        }
        return false;
    }
    public function make_user_id($data)
    {
        $data['user_url'] = make_uniqueid();
        return $data;
    }
    public function make_school_id($data)
    {

        $data['school_id'] =  make_uniqueid();
        return $data;
    }
}
