<?php

namespace App\Controllers;

use App\Models\RecordModel;

class Records extends BaseController
{
    protected $recordModel;

    public function __construct()
    {
        $this->recordModel = new RecordModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // if RecordModel::$useSoftDeletes = true then deleted rows are
        // automatically excluded; otherwise add ->where('deleted_at', null)
        $data['records'] = $this->recordModel->findAll();
        return view('records/index', $data);
    }

    public function create()
    {
        // make sure the view always has a validation object
        return view('records/create', [
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = [
            'title'    => 'required|min_length[3]|max_length[200]',
            'status'   => 'required|in_list[active,inactive,pending]',
            'priority' => 'required|integer|greater_than[0]|less_than[6]',
        ];

        if (! $this->validate($rules)) {
            return view('records/create', [
                'validation' => $this->validator,
            ]);
        }

        $this->recordModel->insert([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category'    => $this->request->getPost('category'),
            'status'      => $this->request->getPost('status'),
            'priority'    => $this->request->getPost('priority'),
        ]);

        return redirect()->to('/records')->with('success', 'Record created successfully!');
    }

    public function show($id)
    {
        $record = $this->recordModel->find($id);

        if (! $record) {
            return redirect()->to('/records')->with('error', 'Record not found.');
        }

        return view('records/show', ['record' => $record]);
    }

    public function edit($id)
    {
        $record = $this->recordModel->find($id);

        if (! $record) {
            return redirect()->to('/records')->with('error', 'Record not found.');
        }

        return view('records/edit', [
            'record'     => $record,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $rules = [
            'title'    => 'required|min_length[3]|max_length[200]',
            'status'   => 'required|in_list[active,inactive,pending]',
            'priority' => 'required|integer|greater_than[0]|less_than[6]',
        ];

        if (! $this->validate($rules)) {
            return view('records/edit', [
                'record'     => $this->recordModel->find($id),
                'validation' => $this->validator,
            ]);
        }

        $this->recordModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category'    => $this->request->getPost('category'),
            'status'      => $this->request->getPost('status'),
            'priority'    => $this->request->getPost('priority'),
        ]);

        return redirect()->to('/records')->with('success', 'Record updated successfully!');
    }

    public function delete($id)
    {
        // let the model handle soft deletes; ensure $useSoftDeletes = true
        $this->recordModel->delete($id);

        return redirect()->to('/records')->with('success', 'Record deleted successfully!');
    }
}