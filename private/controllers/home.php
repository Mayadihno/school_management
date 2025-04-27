<?php


class Home extends Controller
{

    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }

        $this->view('home');
    }
}
