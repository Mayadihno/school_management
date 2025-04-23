<?php

class Switch_school extends Controller
{

    public function index($id = '')
    {

        Auth::switch_school($id);
        $this->redirect('schools');
    }
}
