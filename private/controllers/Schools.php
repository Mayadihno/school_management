<?php


class Schools extends Controller
{

    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $school = new School();
        $data = $school->findAll();
        $this->view('schools', ['schools' => $data]);
    }
}
