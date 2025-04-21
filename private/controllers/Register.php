<?php


class Register extends Controller
{

    public function index()
    {

        $error = array();
        if (count($_POST) > 0) {
            $user = new User();
            if ($user->validate($_POST)) {
                $_POST['date'] = date('Y-m-d H:i:s');
                $user->insert($_POST);
                $this->redirect('login');
            } else {
                $error = $user->errors;
            }
        }
        $this->view('register', ['errors' => $error]);
    }
}
