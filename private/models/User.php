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
        'image',
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
            // Creating a new user
            if ($this->where('email', $data['email'])) {
                $this->errors['email'] = "Email already exists";
            }
        } else {
            // Updating existing user
            $query = "SELECT email FROM $this->table WHERE email = :email AND user_id != :user_id";
            $result = $this->query($query, [
                'email' => $data['email'],
                'user_id' => $id
            ]);

            if ($result) {
                $this->errors['email'] = "Email already exists in database";
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
        // Always verify current password first
        if (empty($data['password'])) {
            $this->errors['password'] = " password is required";
        } else {
            $user = $this->whereOne('user_id', $id);
            if ($user && !password_verify($data['password'], $user->password)) {
                $this->errors['password'] = " password is incorrect";
            }
        }

        // If user is updating password, validate it
        if (!empty($data['password'])) {
            if (strlen($data['password']) < 6) {
                $this->errors['password'] = "Password must be at least 6 characters long";
            }

            if (empty($data['confirm-password']) || $data['password'] !== $data['confirm-password']) {
                $this->errors['confirm-password'] = "Passwords do not match";
            }
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
