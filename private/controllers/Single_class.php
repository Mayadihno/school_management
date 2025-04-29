<?php


class Single_class extends Controller
{

    public function index($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $class = new Classes_model;
        $data = $class->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if ($data) {
            $crumbs[] = [$data->class, 'class'];
        }
        $limit = 2;
        $pager = new Pager($limit);
        $offset = $pager->offset;

        $lect = new Lecturers_model();
        $results = false;
        $page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'lecturers';

        if ($page_tab == 'lecturers') {
            $query = "select * from class_lecturers where class_id = :class_id && disabled = 0 order by date desc limit $limit offset $offset";
            $lecturers = $lect->query($query, ['class_id' => $id]);
            $datas['lecturers'] = $lecturers;
        } else {
            if ($page_tab == 'students') {
                $query = "select * from class_students where class_id = :class_id && disabled = 0 order by date desc limit $limit offset $offset";
                $students = $lect->query($query, ['class_id' => $id]);
                $datas['students'] = $students;
            }
        }


        $datas['class'] = $data;
        $datas['crumbs'] = $crumbs;
        $datas['page_tab'] = $page_tab;
        $datas['results'] = $results;
        $datas['errors'] = $errors;
        $datas['pager'] = $pager;

        $this->view('single-class', $datas);
    }

    public function lecturersadd($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $class = new Classes_model;
        $data = $class->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if ($data) {
            $crumbs[] = [$data->class, 'class'];
        }
        $lect = new Lecturers_model();
        $results = false;
        $page_tab = 'lecturers-add';

        if (count($_POST) > 0) {
            if (isset($_POST['search'])) {
                if (!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = '%' . trim($_POST['name']) . '%';
                    $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'lecturer' limit 10";
                    $results = $user->query($query, ['fname' => $name, 'lname' => $name]);
                } else {
                    $errors[] = 'Please enter lecturer name';
                }
            } else {
                if (isset($_POST['selected'])) {
                    $query = "select disabled,id from class_lecturers where class_id = :class_id && user_id = :user_id limit 1";

                    if (!$check = $lect->query($query, ['class_id' => $id, 'user_id' => $_POST['selected']])) {
                        $arr = array();
                        $arr['class_id'] = $id;
                        $arr['user_id'] = $_POST['selected'];
                        $arr['disabled'] = 0;
                        $arr['date'] = date('Y-m-d H:i:s');
                        $lect->insert($arr);

                        $this->redirect('single_class/' . $id . '?tab=lecturers');
                    } else {
                        //check if he is active
                        if (isset($check[0]->disabled)) {
                            if ($check[0]->disabled) {
                                $arr = array();
                                $arr['disabled'] = 0;
                                $lect->update($check[0]->id, $arr);
                                $this->redirect('single_class/' . $id . '?tab=lecturers');
                            }
                        } else {
                            $errors[] = 'Lecturer already added';
                        }
                        $errors[] = 'Lecturer already added';
                    }
                }
            }
        }

        $datas['class'] = $data;
        $datas['crumbs'] = $crumbs;
        $datas['page_tab'] = $page_tab;
        $datas['results'] = $results;
        $datas['errors'] = $errors;


        $this->view('single-class', $datas);
    }
    public function studentsadd($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $class = new Classes_model;
        $data = $class->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if ($data) {
            $crumbs[] = [$data->class, 'class'];
        }
        $stud = new Students_model();
        $results = false;
        $page_tab = 'students-add';

        if (count($_POST) > 0) {
            if (isset($_POST['search'])) {
                if (!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = '%' . trim($_POST['name']) . '%';
                    $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'student' limit 10";
                    $results = $user->query($query, ['fname' => $name, 'lname' => $name]);
                } else {
                    $errors[] = 'Please enter Student name';
                }
            } else {
                if (isset($_POST['selected'])) {
                    $query = "select disabled,id from class_students where class_id = :class_id && user_id = :user_id limit 1";

                    if (!$check = $stud->query($query, ['class_id' => $id, 'user_id' => $_POST['selected']])) {
                        $arr = array();
                        $arr['class_id'] = $id;
                        $arr['user_id'] = $_POST['selected'];
                        $arr['disabled'] = 0;
                        $arr['date'] = date('Y-m-d H:i:s');
                        $stud->insert($arr);

                        $this->redirect('single_class/' . $id . '?tab=students');
                    } else {
                        //check if he is active
                        if (isset($check[0]->disabled)) {
                            if ($check[0]->disabled) {
                                $arr = array();
                                $arr['disabled'] = 0;
                                $stud->update($check[0]->id, $arr);
                                $this->redirect('single_class/' . $id . '?tab=students');
                            }
                        } else {
                            $errors[] = 'Student already added';
                        }
                        $errors[] = 'Student already added';
                    }
                }
            }
        }

        $datas['class'] = $data;
        $datas['crumbs'] = $crumbs;
        $datas['page_tab'] = $page_tab;
        $datas['results'] = $results;
        $datas['errors'] = $errors;


        $this->view('single-class', $datas);
    }


    public function lecturersremove($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $class = new Classes_model;
        $data = $class->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if ($data) {
            $crumbs[] = [$data->class, 'class'];
        }
        $lect = new Lecturers_model();
        $results = false;
        $page_tab = 'lecturers-remove';

        if (count($_POST) > 0) {
            if (isset($_POST['search'])) {
                if (!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = '%' . trim($_POST['name']) . '%';
                    $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'lecturer' limit 10";
                    $results = $user->query($query, ['fname' => $name, 'lname' => $name]);
                } else {
                    $errors[] = 'Please enter lecturer name';
                }
            } else {
                if (isset($_POST['selected'])) {
                    $query = "select id from class_lecturers where class_id = :class_id && user_id = :user_id && disabled = 0 limit 1";
                    if ($row = $lect->query($query, ['class_id' => $id, 'user_id' => $_POST['selected']])) {
                        $arr = array();
                        $arr['disabled'] = 1;
                        $lect->update($row[0]->id, $arr);
                        $this->redirect('single_class/' . $id . '?tab=lecturers');
                    }
                } else {
                    $errors[] = 'Invalid action. Please try again';
                }
            }
        }

        $datas['class'] = $data;
        $datas['crumbs'] = $crumbs;
        $datas['page_tab'] = $page_tab;
        $datas['results'] = $results;
        $datas['errors'] = $errors;


        $this->view('single-class', $datas);
    }
    public function studentsremove($id = '')
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $errors = array();
        $class = new Classes_model;
        $data = $class->whereOne('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        if ($data) {
            $crumbs[] = [$data->class, 'class'];
        }
        $stud = new Students_model();
        $results = false;
        $page_tab = 'students-remove';

        if (count($_POST) > 0) {
            if (isset($_POST['search'])) {
                if (!empty(trim($_POST['name']))) {
                    $user = new User();
                    $name = '%' . trim($_POST['name']) . '%';
                    $query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'student' limit 10";
                    $results = $user->query($query, ['fname' => $name, 'lname' => $name]);
                } else {
                    $errors[] = 'Please enter Student name';
                }
            } else {
                if (isset($_POST['selected'])) {
                    $query = "select id from class_students where class_id = :class_id && user_id = :user_id && disabled = 0 limit 1";
                    if ($row =  $stud->query($query, ['class_id' => $id, 'user_id' => $_POST['selected']])) {
                        $arr = array();
                        $arr['disabled'] = 1;
                        $stud->update($row[0]->id, $arr);
                        $this->redirect('single_class/' . $id . '?tab=students');
                    }
                } else {
                    $errors[] = 'Invalid action. Please try again';
                }
            }
        }

        $datas['class'] = $data;
        $datas['crumbs'] = $crumbs;
        $datas['page_tab'] = $page_tab;
        $datas['results'] = $results;
        $datas['errors'] = $errors;


        $this->view('single-class', $datas);
    }
}
