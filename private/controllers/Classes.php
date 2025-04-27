<?php


class Classes extends Controller
{

    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $classes = new Classes_model();
        $school_id =  Auth::getSchool_id();
        $data =  $classes->query("select * from classes where school_id = :school_id order by date desc", ['school_id' => $school_id]);

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        $this->view('classes', ['classes' => $data, 'crumbs' => $crumbs]);
    }


    public function add()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }

        $errors = array();
        if (count($_POST) > 0) {
            $classes = new Classes_model();
            if ($classes->validate($_POST)) {
                $_POST['date'] = date('Y-m-d H:i:s');
                $classes->insert($_POST);
                $this->redirect('classes');
            } else {
                $errors = $classes->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Classes', 'classes'];
        $crumbs[] = ['Add', 'classes/add'];

        $this->view('classes.add', ['errors' => $errors, 'crumbs' => $crumbs]);
    }

    public function edit($id = null)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $classes = new Classes_model();;
        $errors = array();
        if (count($_POST) > 0) {
            $classes = new Classes_model();
            if ($classes->validate($_POST)) {
                $classes->update($id, ($_POST));
                $this->redirect('classes');
            } else {
                $errors = $classes->errors;
            }
        }

        $classes = $classes->where('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['classes', 'classes'];
        $crumbs[] = ['Edit', 'classes/edit'];
        $this->view('classes.edit', ['errors' => $errors, 'classes' => $classes, 'crumbs' => $crumbs]);
    }
    public function delete($id)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $classes = new Classes_model();
        $errors = array();
        if ($id) {
            $classes->delete($id);
            $this->redirect('classes');
        } else {
            $errors = $classes->errors;
        }

        $classes = $classes->where('id', $id);

        $this->view('classes.delete', ['errors' => $errors, 'classes' => $classes]);
    }
}
