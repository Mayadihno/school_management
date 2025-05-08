<?php

class Answers_model extends Model
{

    protected $table = 'answers';

    protected $allowedColumns = [
        'question_id',
        'date',
        'test_id',
        'user_id',
        'answer',
    ];
    protected $beforeInsert = [];
    protected $afterSelect = [];

    public function validate($data)
    {
        $this->errors = array();
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
}
