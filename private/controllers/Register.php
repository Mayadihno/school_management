<?php


class Register extends Controller
{

    public function index()
    {
        $mode = isset($_GET['mode']) ? $_GET['mode'] : '';
        $error = array();
        if (count($_POST) > 0) {
            $user = new User();
            if ($user->validate($_POST)) {
                $_POST['date'] = date('Y-m-d H:i:s');
                $user->insert($_POST);
                $redirect = $mode == 'students' ? 'students' : 'users';
                $this->redirect($redirect);
            } else {
                $error = $user->errors;
            }
        }

        $this->view('register', ['errors' => $error, 'mode' => $mode]);
    }
}
