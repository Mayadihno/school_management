<?php


class Single_class extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $user = new User();
        $data = $user->whereOne('user_id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if ($data) {
            $crumbs[] = [$data->class, 'class'];
        }
        $this->view('single-class', ['class' => $data, 'crumbs' => $crumbs]);
    }
}
