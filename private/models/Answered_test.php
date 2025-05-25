<?php

/**
 * Answered test model
 */
class Answered_test extends Model
{
    protected $table = 'answered_tests';

    protected $allowedColumns = [];

    protected $beforeInsert = [];

    protected $afterSelect = [
        'get_user',
    ];



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
