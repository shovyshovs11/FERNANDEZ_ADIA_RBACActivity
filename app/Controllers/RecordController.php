<?php

namespace App\Controllers;

use App\Models\RecordModel;

class RecordController extends BaseController
{
    protected $recordModel;

    public function __construct()
    {
        $this->recordModel = new RecordModel();
    }

    // List all records
    public function index()
    {
        $data = [
            'title' => 'All Records',
            'records' => $this->recordModel->findAll()
        ];
        return view('records/index', $data);
    }

    // Show create form
    public function create()
    {
        $data = ['title' => 'Create Record'];
        return view('records/create', $data);
    }

    // Store new record
    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[1000]',
            'category' => 'permit_empty|max_length[100]',
            'status' => 'required|in_list[active,inactive,pending]',
            'price' => 'permit_empty|decimal'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category' => $this->request->getPost('category'),
            'status' => $this->request->getPost('status'),
            'price' => $this->request->getPost('price') ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->recordModel->insert($data);
        return redirect()->to('/records')->with('success', 'Record created successfully!');
    }

    // Show single record
    public function show($id)
    {
        $record = $this->recordModel->find($id);
        if (!$record) {
            return redirect()->to('/records')->with('error', 'Record not found.');
        }
        
        $data = [
            'title' => 'View Record',
            'record' => $record
        ];
        return view('records/show', $data);
    }

    // Show edit form
    public function edit($id)
    {
        $record = $this->recordModel->find($id);
        if (!$record) {
            return redirect()->to('/records')->with('error', 'Record not found.');
        }

        $data = [
            'title' => 'Edit Record',
            'record' => $record
        ];
        return view('records/edit', $data);
    }

    // Update record
    public function update($id)
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[1000]',
            'category' => 'permit_empty|max_length[100]',
            'status' => 'required|in_list[active,inactive,pending]',
            'price' => 'permit_empty|decimal'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'category' => $this->request->getPost('category'),
            'status' => $this->request->getPost('status'),
            'price' => $this->request->getPost('price') ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->recordModel->update($id, $data);
        return redirect()->to('/records')->with('success', 'Record updated successfully!');
    }

    // Delete record (HARD DELETE SA DATABASE)
    public function delete($id)
    {
        $record = $this->recordModel->find($id);
        if (!$record) {
            return redirect()->to('/records')->with('error', 'Record not found.');
        }

        // Hard delete ulit
        $this->recordModel->delete($id);
        return redirect()->to('/records')->with('success', 'Record deleted successfully!');
    }
}