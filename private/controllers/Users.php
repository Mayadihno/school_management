<?php


class Users extends Controller
{
    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $user = new User();
        $data = $user->findAll();
        $this->view('users', ['users' => $data]);
    }
}
