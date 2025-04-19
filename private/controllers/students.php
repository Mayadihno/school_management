<?php


class Students extends Controller
{

    public function index($id = '')
    {
        echo "Students controller loaded<br>" . $id;
    }
}
