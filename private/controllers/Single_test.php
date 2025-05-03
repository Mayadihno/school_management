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
        $question = new Question_model;
        $data = $tests->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if ($data) {
            $crumbs[] = [$data->test, 'tests'];
        }

        $limit = 2;
        $pager = new Pager($limit);
        $offset = $pager->offset;
        $page_tab = 'view';

        $testss = $tests->where('id', $id);
        $questions = $question->where('test_id', $testss[0]->test_id,);
        $total_questions = 0;
        if (isset($questions) && !empty($questions)) {
            foreach ($questions as $question) {
                $total_questions++;
            }
        }

        $results = false;


        $datas['test'] = $data;
        $datas['questions'] = $questions;
        $datas['crumbs'] = $crumbs;
        $datas['results'] = $results;
        $datas['errors'] = $errors;
        $datas['page_tab'] = $page_tab;
        $datas['total_questions'] = $total_questions;
        $datas['pager'] = $pager;

        $this->view('single-test', $datas);
    }

    public function addsubjective($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $tests = new Tests_model;
        $data = $tests->whereOne('test_id', $id);
        $row = $tests->whereOne('test_id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if ($data) {
            $crumbs[] = [$data->test, 'tests'];
        }

        $limit = 2;
        $pager = new Pager($limit);
        $offset = $pager->offset;
        $page_tab = 'add-subjective';
        $question = new Question_model;

        if (count($_POST) > 0) {

            $data = $_POST;
            $data['test_id'] = $id;
            if ($question->validate($data)) {

                if ($myImage = upload_images($_FILES)) {
                    $data['image'] = $myImage;
                }


                $data['date'] = date('Y-m-d H:i:s');

                if (isset($_GET['type']) && $_GET['type'] == 'objective') {
                    $data['question_type'] = 'objective';
                } else {
                    $data['question_type'] = 'subjective';
                }



                $question->insert($data);
                $this->redirect('single_test/' . $row->id . '?tab=view');
            } else {
                $errors  = "Unable to add question, please try again later";;
            }
        }

        $results = false;


        $datas['test'] = $data;
        $datas['crumbs'] = $crumbs;
        $datas['results'] = $results;
        $datas['errors'] = $errors;
        $datas['page_tab'] = $page_tab;
        $datas['pager'] = $pager;

        $this->view('single-test', $datas);
    }

    public function editquestion($id = '', $question_id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $tests = new Tests_model;
        $data = $tests->whereOne('test_id', $id);
        $row = $tests->whereOne('test_id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if ($data) {
            $crumbs[] = [$data->test, 'tests'];
        }
        $limit = 2;
        $pager = new Pager($limit);
        $offset = $pager->offset;
        $page_tab = 'edit-question';
        $question = new Question_model;
        $quest = $question->whereOne('id', $question_id);


        if (count($_POST) > 0) {

            $data = $_POST;
            if ($question->validate($data)) {

                if ($myImage = upload_images($_FILES)) {
                    $data['image'] = $myImage;
                }

                $question->update($id, $data);
                $this->redirect('single_test/editquestion/' . $row->id . '?tab=view');
            } else {
                $errors  = "Unable to add question, please try again later";;
            }
        }

        $results = false;


        $datas['test'] = $data;
        $datas['quest'] = $quest;
        $datas['crumbs'] = $crumbs;
        $datas['results'] = $results;
        $datas['errors'] = $errors;
        $datas['page_tab'] = $page_tab;
        $datas['pager'] = $pager;

        $this->view('single-test', $datas);
    }
}
