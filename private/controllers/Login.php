<?php


class Login extends Controller
{

    public function index()
    {
        $error = array();
        if (count($_POST) > 0) {
            $user = new User();
            $row = $user->where('email', $_POST['email']);
            if ($row) {
                $row = $row[0];
                if (password_verify($_POST['password'], $row->password)) {
                    Auth::authenticate($row);
                    $this->redirect('home');
                } else {
                    $error['password'] = 'Wrong email or passsword';
                }
            } else {
                $error['email'] = 'Wrong email or passsword';
            }
        }

        $this->view('login', ['errors' => $error]);
    }
}
