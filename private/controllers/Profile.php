<?php


class Profile extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $user = new User();
        $data = $user->whereOne('user_id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Users', 'users'];
        if ($data) {
            $crumbs[] = [$data->firstname, 'profile'];
        }
        $this->view('profile', ['user' => $data, 'crumbs' => $crumbs]);
    }
}
