<?php


class Schools extends Controller
{

    public function index()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $school = new School();
        $data = $school->findAll();
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        if (Auth::access('super-admin')) {
            $this->view('schools', ['schools' => $data, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }


    public function add()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }

        $errors = array();
        if (count($_POST) > 0  && Auth::access('super-admin')) {
            $school = new School();
            if ($school->validate($_POST)) {
                $_POST['date'] = date('Y-m-d H:i:s');
                $school->insert($_POST);
                $this->redirect('schools');
            } else {
                $errors = $school->errors;
            }
        }

        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        $crumbs[] = ['Add', 'schools/add'];

        if (Auth::access('super-admin')) {
            $this->view('schools.add', ['errors' => $errors, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }

    public function edit($id = null)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $school = new School();
        $errors = array();
        if (count($_POST) > 0 && Auth::access('super-admin')) {
            $school = new School();
            if ($school->validate($_POST)) {
                $school->update($id, ($_POST));
                $this->redirect('schools');
            } else {
                $errors = $school->errors;
            }
        }

        $school = $school->where('id', $id);
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Schools', 'schools'];
        $crumbs[] = ['Edit', 'schools/edit'];
        if (Auth::access('super-admin')) {
            $this->view('schools.edit', ['errors' => $errors, 'school' => $school, 'crumbs' => $crumbs]);
        } else {
            $this->view('access-denied');
        }
    }
    public function delete($id)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $school = new School();
        $errors = array();
        if ($id && Auth::access('super-admin')) {
            $school->delete($id);
            $this->redirect('schools');
        } else {
            $errors = $school->errors;
        }

        $school = $school->where('id', $id);

        if (Auth::access('super-admin')) {
            $this->view('schools.delete', ['errors' => $errors, 'school' => $school]);
        } else {
            $this->view('access-denied');
        }
    }
}
