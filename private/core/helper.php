<?php

function get_value($key, $default = '', $method = 'post')
{
    $data = $method;
    if ($method == 'get') {
        $data = $_GET;
    }
    if (isset($data[$key])) {
        return $data[$key];
    }
    return $default;
}

function get_select($key, $value)
{
    if (isset($_POST[$key]) && $_POST[$key] == $value) {
        return 'selected';
    }
    return '';
}

function esc($val)
{
    return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

function make_uniqueid()
{
    $uniq = uniqid('', true);
    $cleaned = str_replace('.', '', $uniq);
    $base = substr($cleaned, 0, 13);
    $random = substr(str_shuffle(RANDOM), 0, 40);
    $text = $base . $random;
    return $text;
}


function get_date($date)
{
    return date("jS M, Y", strtotime($date));
}

function get_date2($date)
{
    return date("F jS, Y H:i:s a", strtotime($date));
}

function show($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}


function get_image($image, $gender = '')
{
    if (!file_exists($image)) {
        $image = ASSETS . 'female-icon.jpg';
        if ($gender == 'male') {
            $image = ASSETS . 'male-icon.png';
        }
    } else {
        $class_image = new Image();
        $image = ROOT . $class_image->profile_thumbnail($image);
    }
    return $image;
}


function view_path($view)
{
    if (file_exists(__DIR__ . '/../views/' . $view . '.inc.php')) {
        return __DIR__ . '/../views/' . $view . '.inc.php';
    } else {
        return __DIR__ . '/../views/notFound.view.php';
    }
}


function upload_images($FILES)
{
    $alllowed_ext = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

    if (count($FILES) > 0 && $FILES['image']['name'] != '') {
        if ($FILES['image']['error'] == 0 && in_array($FILES['image']['type'], $alllowed_ext)) {
            $folder = 'uploads/';
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            $destination = $folder . time() . '_' . $FILES['image']['name'];
            move_uploaded_file($FILES['image']['tmp_name'], $destination);
            return $destination;
        }
    }
    return false;
}

function has_taken_test($test_id)
{
    return "No";
}

function can_take_test($test_id)
{

    $class = new Classes_model();
    $my_table = "class_students";

    if (Auth::getRank() != 'student') {
        return false;
    }

    $id = Auth::getUser_id();

    $query = "select * from $my_table where user_id = :user_id && disabled = 0";

    $data['stud_classes'] = $class->query($query, ['user_id' => $id]);

    $data['student_classes'] = [];
    if (isset($data['stud_classes']) && !empty($data['stud_classes'])) {
        foreach ($data['stud_classes'] as $stud_class) {
            $data['student_classes'][] = $class->whereOne('class_id', $stud_class->class_id);
        }
    }
    $class_ids = [];
    foreach ($data['student_classes'] as $stud_class) {
        $class_ids[] = $stud_class->class_id;
    }
    $id_string = "'" . implode("','", $class_ids) . "'";
    $query = "select * from tests where class_id in ($id_string) && disabled = 0 order by date desc";
    $test_model = new Tests_model();
    $tests = $test_model->query($query, []);
    $data['tests'] = $tests;

    $my_tests = array_column($tests, 'test_id');
    if (in_array($test_id, $my_tests)) {
        return true;
    }

    return "No";
}

function get_answer($saved_ans, $question_id)
{

    if (!empty($saved_ans)) {
        foreach ($saved_ans as $ans) {
            if ($ans->question_id == $question_id) {
                return $ans->answer;
            }
        }
    }
    return '';
}

function get_answer_mark($saved_ans, $question_id)
{

    if (!empty($saved_ans)) {
        foreach ($saved_ans as $ans) {
            if ($ans->question_id == $question_id) {
                return $ans->answer_mark;
            }
        }
    }
    return '';
}

function get_answer_percentage1($questions, $saved_ans)
{
    $total_answers_count = 0;
    if (!empty($questions)) {
        foreach ($saved_ans as $quest) {
            $answers = get_answer($saved_ans, $quest->question_id);
            if (trim($answers) != '') {
                $total_answers_count++;
            }
        }
    }
    if ($total_answers_count > 0) {
        return round(($total_answers_count / count($questions)) * 100, 1);
    }
    return 0;
}

function get_answer_percentage($test_id, $user_id)
{


    $answers = new Answers_model();
    $query = 'select question_id,answer from answers where test_id = :id and user_id = :user_id';
    $saved_ans = $answers->query($query, ['id' => $test_id, 'user_id' => $user_id]);

    if (empty($saved_ans)) {
        return 0;
    }


    $tests = new Tests_model;
    $testss = $tests->where('id', $test_id);
    $quests = new Question_model();
    $questions = $quests->query('select * from test_questions where test_id = :test_id order by date asc', ['test_id' => $testss[0]->test_id]);


    $total_answers_count = 0;
    if (!empty($questions)) {
        foreach ($saved_ans as $quest) {
            $answers = get_answer($saved_ans, $quest->question_id);
            if (trim($answers) != '') {
                $total_answers_count++;
            }
        }
    }
    if ($total_answers_count > 0) {
        return round(($total_answers_count / count($questions)) * 100, 1);
    }
    return 0;
}

function get_mark_percentage($test_id, $user_id)
{


    $answers = new Answers_model();
    $query = 'select question_id,answer,answer_mark from answers where test_id = :id and user_id = :user_id';
    $saved_ans = $answers->query($query, ['id' => $test_id, 'user_id' => $user_id]);

    if (empty($saved_ans)) {
        return 0;
    }


    $tests = new Tests_model;
    $testss = $tests->where('id', $test_id);
    $quests = new Question_model();
    $questions = $quests->query('select * from test_questions where test_id = :test_id order by date asc', ['test_id' => $testss[0]->test_id]);


    $total_answers_count = 0;
    if (!empty($questions)) {
        foreach ($saved_ans as $quest) {
            $answers = get_answer_mark($saved_ans, $quest->question_id);
            if (trim($answers) > 0) {
                $total_answers_count++;
            }
        }
    }
    if ($total_answers_count > 0) {
        return round(($total_answers_count / count($questions)) * 100, 1);
    }
    return 0;
}

function get_score_percentage($test_id, $user_id)
{


    $answers = new Answers_model();
    $query = 'select question_id,answer,answer_mark from answers where test_id = :id and user_id = :user_id';
    $saved_ans = $answers->query($query, ['id' => $test_id, 'user_id' => $user_id]);

    if (empty($saved_ans)) {
        return 0;
    }


    $tests = new Tests_model;
    $testss = $tests->where('id', $test_id);
    $quests = new Question_model();
    $questions = $quests->query('select * from test_questions where test_id = :test_id order by date asc', ['test_id' => $testss[0]->test_id]);


    $total_answers_count = 0;
    if (!empty($questions)) {
        foreach ($saved_ans as $quest) {
            $answers = get_answer_mark($saved_ans, $quest->question_id);
            if (trim($answers) == 1) {
                $total_answers_count++;
            }
        }
    }
    if ($total_answers_count > 0) {
        return round(($total_answers_count / count($questions)) * 100, 1);
    }
    return 0;
}

function get_unsubmitted_test_rows()
{
    if (Auth::getRank() == "student") {
        $tests_class = new Tests_model();
        //$query = "select test_id from tests where class_id in (select class_id from class_students where user_id = :user_id) and test_id not in (select test_id from answered_tests where user_id = :user_id && submitted = 1)";
        $query = 'select test_id from answered_tests where user_id = :user_id and submitted = 0';
        $data = $tests_class->query($query, ['user_id' => Auth::getUser_id()]);

        if ($data) {
            return array_column($data, 'test_id');
        }
    }

    return [];
}

function get_unsubmitted_tests()
{
    if (Auth::getRank() == "student") {

        $tests_class = new Tests_model();
        // $query = "select id from tests where class_id in (select class_id from class_students where user_id = :user_id) and test_id not in (select test_id from answered_tests where user_id = :user_id && submitted = 1) && disabled = 0";
        $query = 'select id from answered_tests where user_id = :user_id and submitted = 0';

        $data = $tests_class->query($query, ['user_id' => Auth::getUser_id()]);
        // show($data);


        if ($data) {
            return count($data);
        }
    }

    return 0;
}


function get_year()
{
    $arr = [];
    $db = new Database();
    $query = "select date from classes order by date asc limit 1";
    $data = $db->query($query);
    if ($data) {
        $year = date("Y", strtotime($data[0]->date));
        $arr[] = $year;
        $cur_year = date("Y", time());

        while ($year < $cur_year) {
            $year++;
            $arr[] = $year;
        }
    } else {
        $year = date("Y", time());
        $arr[] = $year;
    }
    rsort($arr);
    return $arr;
}


switch_year();
function switch_year()
{
    if (!isset($_SESSION['SCHOOL_YEAR'])) {
        $_SESSION['SCHOOL_YEAR'] = (object)[];
        $_SESSION['SCHOOL_YEAR']->year = date("Y", time());
    }
    if (!empty($_GET['school_year'])) {
        $school_year = (int) $_GET['school_year'];
        $_SESSION['SCHOOL_YEAR']->year = $school_year;
    } else {
        $_SESSION['SCHOOL_YEAR']->year = date("Y", time());
    }
}

function add_get_vars()
{
    $text = '';
    if (!empty($_GET)) {
        foreach ($_GET as $key => $value) {
            if ($key != "url" && $key != "school_year") {
                $text .= "<input type='hidden' name='$key' value='$value' />";
            }
        }
    }

    return $text;
}
