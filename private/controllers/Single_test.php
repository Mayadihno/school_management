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

    public function addquestion($id = '')
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
        $page_tab = 'add-question';
        $question = new Question_model;

        if (count($_POST) > 0) {

            $data = $_POST;
            $data['test_id'] = $id;
            if ($question->validate($data)) {

                if ($myImage = upload_images($_FILES)) {
                    $data['image'] = $myImage;
                }

                $_POST['test_id'] = $id;
                $data['date'] = date("Y-m-d H:i:s");


                if (isset($_GET['type']) && $_GET['type'] == "multiple") {
                    $data['question_type'] = 'multiple';
                    //for multiple choice
                    $num = 0;
                    $arr = [];
                    $letters = ['A', 'B', 'C', 'D', 'F', 'G', 'H', 'I', 'J'];
                    foreach ($_POST as $key => $value) {
                        // code...
                        if (strstr($key, 'choice')) {

                            $arr[$letters[$num]] = $value;
                            $num++;
                        }
                    }

                    $data['choices'] = json_encode($arr);
                } else
 				if (isset($_GET['type']) && $_GET['type'] == "objective") {
                    $data['question_type'] = 'objective';
                } else {
                    $data['question_type'] = 'subjective';
                }



                $question->insert($data);
                $this->redirect('single_test/' . $row->id . '?tab=view');
            } else {
                $errors[]  = "Unable to add question, please try again later";;
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

                // Handle image upload
                if ($myImage = upload_images($_FILES)) {
                    $data['image'] = $myImage;

                    // Delete old image
                    $old_image = $quest->image;
                    if (isset($old_image) && file_exists($old_image)) {
                        unlink($old_image);
                    }
                }

                $type = '';

                // Handle multiple choice questions
                if ($quest->question_type == 'objective') {
                    $type = '?type=objective';
                } else if (isset($_GET['type']) && $_GET['type'] == "multiple") {

                    $data['question_type'] = 'multiple';

                    $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                    $choices = [];

                    foreach ($letters as $letter) {
                        if (!empty($_POST[$letter])) {
                            $choices[$letter] = $_POST[$letter];
                        }
                    }

                    $data['correct_answer'] = $_POST['correct_answer'] ?? '';
                    $data['choices'] = json_encode($choices);
                    $type = '?type=multiple';
                } else {
                    $type = '?type=subjective';
                }

                // ✅ Sanitize the $data array to avoid invalid columns like 'A', 'B', etc.
                $allowed = ['question', 'comment', 'correct_answer', 'test_id', 'question_type', 'choices', 'image'];
                $filteredData = [];

                foreach ($data as $key => $value) {
                    if (in_array($key, $allowed)) {
                        $filteredData[$key] = $value;
                    }
                }

                // Save the updated question
                $question->update($quest->id, $filteredData);

                $this->redirect('single_test/editquestion/' . $id . '/' . $question_id . $type);
            } else {
                $errors[] = "Unable to add question, please try again later";
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

    public function deletequestion($id = '', $question_id = '')
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
        if (isset($quest->image) && file_exists($quest->image)) {
            unlink($quest->image);
        }


        if ($question_id) {
            $question->delete($question_id);

            $this->redirect('single_test/' . $row->id . '?tab=view');
        } else {
            $errors  = "Unable to delete question, please try again later";;
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
}
