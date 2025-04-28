<?php

class Switch_school extends Controller
{

    public function index($id = '')
    {

        if (
            Auth::access('super-admin')
        ) {
            Auth::switch_school($id);
            $this->redirect('schools');
        }
    }
}
