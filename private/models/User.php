<?php


class User extends Model
{

    protected $allowedColumns = [
        'firstname',
        'lastname',
        'email',
        'gender',
        'password',
        'rank',
        'date',
    ];
    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password',
    ];



    public function validate($data, $id = '')
    {
        $this->errors = array();
        //validate firstName
        if (empty($data['firstname']) || !preg_match('/^[A-Za-z]+$/', $data['firstname'])) {
            $this->errors['firstname'] = "First name can only contain letters";
        }
        //validate lastName
        if (empty($data['lastname']) || !preg_match('/^[A-Za-z]+$/', $data['lastname'])) {
            $this->errors['lastname'] = "Last name can only contain letters";
        }
        //validate email
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Email is not valid";
        }
        if (trim($id) == '') {
            //validate email if already exists
            if ($this->where('email', $data['email'])) {
                $this->errors['email'] = "Email already exists";
            }
        } else {
            if ($this->query("select email from $this->table where email = :email && user_id != id", ['email' => $data['email'], 'id' => $id])) {
                $this->errors['email'] = "Email already exists";
            }
        }

        //validate gender
        if (empty($data['gender']) || !in_array($data['gender'], array('male', 'female', 'other'))) {
            $this->errors['gender'] = "Select at least one Gender";
        }
        //validate rank 
        if (empty($data['rank']) || !in_array($data['rank'], array('admin', 'student', 'super-admin', 'lecturer', 'reception'))) {
            $this->errors['rank'] = "Select at least one Rank";
        }
        //validate password
        if (isset($data['password'])) {
            if (empty($data['password']) || strlen($data['password']) < 6) {
                $this->errors['password'] = "Password must be at least 6 characters long";
            }
        }
        //validate confirm password
        if (empty($data['confirm-password']) || $data['password'] != $data['confirm-password']) {
            $this->errors['confirm-password'] = "Passwords do not match";
        }

        if (count($this->errors) == 0) {
            return true;
        }
        return false;
    }

    public function hash_password($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $data;
    }
    public function make_user_id($data)
    {
        $data['user_id'] = make_uniqueid();
        return $data;
    }
    public function make_school_id($data)
    {
        if (isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id;
        }
        return $data;
    }
}
