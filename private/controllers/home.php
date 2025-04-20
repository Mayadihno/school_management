<?php


class Home extends Controller
{

    public function index()
    {
        $user = new User();
        $data = $user->findAll();
        $this->view('home', ['users' => $data]);
    }
}
