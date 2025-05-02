<?php

class Single_test extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $tests = new Tests_model;
        $data = $tests->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if ($data) {
            $crumbs[] = [$data->test, 'tests'];
        }

        $limit = 2;
        $pager = new Pager($limit);
        $offset = $pager->offset;
        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'view';

        $results = false;

        $datas['test'] = $data;
        $datas['crumbs'] = $crumbs;
        $datas['results'] = $results;
        $datas['errors'] = $errors;
        $datas['page_tab'] = $page_tab;
        $datas['pager'] = $pager;

        $this->view('single-test', $datas);
    }
}
