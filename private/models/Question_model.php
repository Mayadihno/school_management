<?php

class Question_model extends Model
{

    protected $table = 'test_questions';

    protected $allowedColumns = [
        'question',
        'date',
        'test_id',
        'question_type',
        'image',
        'correct_answer',
        'choices',
        'comment',
    ];
    protected $beforeInsert = [
        'make_user_id',
        'make_id',
    ];
    protected $afterSelect = [
        'get_user',
    ];

    public function validate($data)
    {
        $this->errors = array();
        if (empty($data['question'])) {
            $this->errors['question'] = "Please add a valid question";
        }

        //check for multiple choice answers
        $num = 0;
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        foreach ($data as $key => $value) {
            // code...
            if (strstr($key, 'choice')) {
                if (empty($value)) {
                    $this->errors['choice' . $num] = "Please add a valid answer in choice " . $letters[$num];
                }
                $num++;
            }
        }

        if (isset($data['correct_answer'])) {
            if (empty($data['correct_answer'])) {
                $this->errors['correct_answer'] = "Please add an answer";
            }
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
