<?php


class Profile extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $user = new User();
        $datas = $user->whereOne('user_id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Users', 'users'];
        if ($datas) {
            $crumbs[] = [$datas->firstname, 'profile'];
        }
        //get more info depending on tab
        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'info';

        $data['page_tab'] =  $page_tab;
        $data['crumbs'] = $crumbs;
        $data['user'] = $datas;

        $this->view('profile', $data);
    }
}
