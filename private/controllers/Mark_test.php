<?php

class Mark_test extends Controller
{

    public function index($id = '', $users_id = '')
    //if two parameters are passed in the url that is how to access it in the controller
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        if (!Auth::access('lecturer')) {
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
            if (!$data->disabled) {
                $query = 'update tests set editable = 0 where id = :id limit 1';
                $tests->query($query, ['id' => $data->id]);
            }
        }
        $db =  new Database();

        //something was posted
        if (count($_POST) > 0) {

            //saved answers
            $data = $_POST;

            // Accessing the nested answers array
            if (isset($data) && is_array($data)) {
                foreach ($data as $question_id => $user_answer) {
                    $insertData = [
                        'test_id' => $id,
                        'user_id' => $users_id,
                        'question_id' => $question_id,
                        'answer_mark' => $user_answer
                    ];

                    $query = 'SELECT id FROM answers WHERE test_id = :test_id AND user_id = :user_id AND question_id = :question_id';
                    $arr = [
                        'test_id' => $insertData['test_id'],
                        'user_id' => $insertData['user_id'],
                        'question_id' => $insertData['question_id']
                    ];
                    $res = $answers->query($query, $arr);
                    if ($res) {
                        $answer_id = $res[0]->id;
                        $arr1 = ['answer_mark' => $insertData['answer_mark']];
                        $answers->update($answer_id, $arr1);
                    }
                }
            }

            $page_number = '&page=1';
            if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                $page_number = '&page=' . $_GET['page'];
            }
            $this->redirect('mark_test/' . $id . '/' . $users_id . $page_number);
        }

        $limit = 2;
        $pager = new Pager($limit);
        $offset = $pager->offset;
        $page_tab = 'view';

        $testss = $tests->where('id', $id);
        $questions = $question->where('test_id', $testss[0]->test_id, 'asc', 'date', $limit, $offset);
        $all_questions = $question->query('select * from test_questions where test_id = :test_id order by date asc', ['test_id' => $testss[0]->test_id]);
        $total_questions = is_array($all_questions) ? count($all_questions) : 0;
        $results = false;


        //if a test is submitted
        if (isset($_GET['unsubmit']) && $_GET['unsubmit'] == 'true') {
            $arr_anss['submitted_date'] = '';
            $arr_anss['submitted'] = 0;
            $arr_anss['test_id'] = $id;
            $arr_anss['user_id'] = $users_id;
            $query = 'update answered_tests set submitted = :submitted, submitted_date = :submitted_date where test_id = :test_id and user_id = :user_id limit 1';
            $db->query($query, $arr_anss);
        }

        //set test as marked
        if (isset($_GET['set_as_mark']) && $_GET['set_as_mark'] == 'true') {
            $arr_anss['marked_date'] = date("Y-m-d H:i:s");
            $arr_anss['marked'] = 1;
            $arr_anss['test_id'] = $id;
            $arr_anss['user_id'] = $users_id;
            $arr_anss['marked_by'] = Auth::getUser_id();
            $query = 'update answered_tests set marked = :marked, marked_date = :marked_date, marked_by = :marked_by where test_id = :test_id and user_id = :user_id limit 1';
            $db->query($query, $arr_anss);
        }


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





        $this->view('mark-test', $datas);
    }
}
