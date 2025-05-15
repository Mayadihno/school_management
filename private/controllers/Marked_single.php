<?php


class Marked_single extends Controller
{

    public function index($id = '', $users_id = '')
    //if two parameters are passed in the url that is how to access it in the controller
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        if (!Auth::access('student')) {
            $this->redirect('access_denied');
        }


        $errors = array();
        $tests = new Tests_model;
        $question = new Question_model;
        $data = $tests->whereOne('id', $id);
        $answers = new Answers_model;

        $query = 'select question_id,answer,answer_mark from answers where test_id = :id and user_id = :user_id';
        $saved_ans = $answers->query($query, ['id' => $id, 'user_id' => $users_id]);


        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Tests', 'tests'];
        if ($data) {
            $crumbs[] = [$data->test, 'tests'];
        }
        $db =  new Database();

        //something was posted

        $limit = 2;
        $pager = new Pager($limit);
        $offset = $pager->offset;
        $page_tab = 'view';

        $testss = $tests->where('id', $id);
        $questions = $question->where('test_id', $testss[0]->test_id, 'asc', 'date', $limit, $offset);
        $all_questions = $question->query('select * from test_questions where test_id = :test_id order by date asc', ['test_id' => $testss[0]->test_id]);
        $total_questions = is_array($all_questions) ? count($all_questions) : 0;
        $results = false;



        //get answered test row
        $datas['answered_test_row'] = $tests->get_answered_test($id, $users_id);

        $datas['submitted'] = false;
        if (isset($datas['answered_test_row']->submitted) && $datas['answered_test_row']->submitted == 1) {
            $datas['submitted'] = true;
        }

        $datas['marked'] = false;
        if (isset($datas['answered_test_row']->marked) && $datas['answered_test_row']->marked == 1) {
            $datas['marked'] = true;
        }

        //get student information 
        if ($datas['answered_test_row']) {
            $user = new User();
            $datas['student_row'] = $user->whereOne('user_id', $datas['answered_test_row']->user_id);
        }


        $datas['test'] = $data;
        $datas['questions'] = $questions;
        $datas['crumbs'] = $crumbs;
        $datas['results'] = $results;
        $datas['errors'] = $errors;
        $datas['page_tab'] = $page_tab;
        $datas['total_questions'] = $total_questions;
        $datas['pager'] = $pager;
        $datas['saved_ans'] = $saved_ans;
        $datas['all_questions'] = $all_questions;
        $datas['user_id'] = $users_id;





        $this->view('marked-single', $datas);
    }
}
