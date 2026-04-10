<?php

namespace App\Controllers;
use App\Models\StudentModel;

class Student extends BaseController
{
    public function index()
    {
        $model = new StudentModel();
        $data = array_merge($this->data, [
            'students' => $model->findAll()
        ]);
        return view('pages/commons/student_view', $data);
    }


    public function store()
    {
        $model = new StudentModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'course' => $this->request->getPost('course'),
        ];
        $model->insert($data);
        return redirect()->to('/students');
    }

    public function delete($id)
    {
        $model = new StudentModel();
        $model->delete($id);
        return redirect()->to('/students');
    }
}

