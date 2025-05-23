<?php

class Take_test extends Controller
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
        $answers = new Answers_model;

        $query = 'select question_id,answer from answers where test_id = :id and user_id = :user_id';
        $saved_ans = $answers->query($query, ['id' => $id, 'user_id' => Auth::getUser_id()]);


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


            $arr_ans['test_id'] = $id;
            $arr_ans['user_id'] = Auth::getUser_id();


            $query = 'select id from answered_tests where test_id = :test_id and user_id = :user_id limit 1';
            $check = $db->query($query, $arr_ans);

            if (!$check) {
                $arr_ans['date'] = date("Y-m-d H:i:s");
                $query = 'insert into answered_tests (test_id,user_id,date) values (:test_id,:user_id,:date)';
                $db->query($query, $arr_ans);
            }

            $data = $_POST;


            // Accessing the nested answers array
            if (isset($data['answer']) && is_array($data['answer'])) {
                foreach ($data['answer'] as $question_id => $user_answer) {
                    $insertData = [
                        'test_id' => $id,
                        'date' => date("Y-m-d H:i:s"),
                        'user_id' => Auth::getUser_id(),
                        'question_id' => $question_id,
                        'answer' => $user_answer
                    ];

                    $query = 'SELECT id FROM answers WHERE test_id = :test_id AND user_id = :user_id AND question_id = :question_id LIMIT 1';
                    $arr = [
                        'test_id' => $insertData['test_id'],
                        'user_id' => $insertData['user_id'],
                        'question_id' => $insertData['question_id']
                    ];
                    $res = $answers->query($query, $arr);
                    if (!$res) {
                        $answers->insert($insertData);
                    } else {
                        $answer_id = $res[0]->id;
                        $arr = ['answer' => $insertData['answer']];
                        $answers->update($answer_id, $arr);
                    }
                }
            }

            $page_number = '&page=1';
            if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                $page_number = '&page=' . $_GET['page'];
            }
            $this->redirect('take_test/' . $id . $page_number);
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
        if (isset($_GET['submit']) && $_GET['submit'] == 'true') {
            $arr_anss['submitted_date'] = date("Y-m-d H:i:s");
            $arr_anss['submitted'] = 1;
            $arr_anss['test_id'] = $id;
            $arr_anss['user_id'] = Auth::getUser_id();
            $query = 'update answered_tests set submitted = :submitted, submitted_date = :submitted_date where test_id = :test_id and user_id = :user_id limit 1';
            $db->query($query, $arr_anss);
            $this->redirect('take_test/' . $id);
        }


        //get answered test row
        $datas['answered_test_row'] = $tests->get_answered_test($id, Auth::getUser_id());


        $datas['submitted'] = false;
        if (isset($datas['answered_test_row']->submitted) && $datas['answered_test_row']->submitted == 1) {
            $datas['submitted'] = true;
        }

        //get student information 
        $user = new User();
        $datas['student_row'] = $user->whereOne('user_id', Auth::getUser_id());

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


        $this->view('take-test', $datas);
    }
}
