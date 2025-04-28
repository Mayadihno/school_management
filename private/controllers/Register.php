<?php


class Register extends Controller
{

    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $mode = isset($_GET['mode']) ? $_GET['mode'] : '';
        $error = array();
        if (count($_POST) > 0) {
            $user = new User();
            if (Auth::access('reception') && $user->validate($_POST)) {
                $_POST['date'] = date('Y-m-d H:i:s');
                if ($_POST['rank'] == 'super-admin' && $_SESSION['USER']->rank != 'super-admin') {
                    $_POST['rank'] == 'admin';
                }
                $user->insert($_POST);
                $redirect = $mode == 'students' ? 'students' : 'users';
                $this->redirect($redirect);
            } else {
                $error = $user->errors;
            }
        }
        if (Auth::access('reception')) {
            $this->view('register', ['errors' => $error, 'mode' => $mode]);
        } else {
            $this->view('access-denied');
        }
    }
}
