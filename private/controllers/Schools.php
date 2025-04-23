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
        $this->view('schools', ['schools' => $data, 'crumbs' => $crumbs]);
    }


    public function add()
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }

        $errors = array();
        if (count($_POST) > 0) {
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

        $this->view('schools.add', ['errors' => $errors, 'crumbs' => $crumbs]);
    }

    public function edit($id = null)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $school = new School();
        $errors = array();
        if (count($_POST) > 0) {
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
        $this->view('schools.edit', ['errors' => $errors, 'school' => $school, 'crumbs' => $crumbs]);
    }
    public function delete($id)
    {
        if (!Auth::authenticated()) {
            $this->redirect('login');
        }
        $school = new School();
        $errors = array();
        if ($id) {
            $school->delete($id);
            $this->redirect('schools');
        } else {
            $errors = $school->errors;
        }

        $school = $school->where('id', $id);

        $this->view('schools.delete', ['errors' => $errors, 'school' => $school]);
    }
}
