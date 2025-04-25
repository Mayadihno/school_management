<?php


class Single_class extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $class = new Classes_model;
        $data = $class->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if ($data) {
            $crumbs[] = [$data->class, 'class'];
        }
        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lecturers';
        $this->view('single-class', ['class' => $data, 'crumbs' => $crumbs, 'page_tab' => $page_tab]);
    }
}
