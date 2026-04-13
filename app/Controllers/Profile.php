<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function show()
    {
        $userId = session('user')['id'] ?? null;

        if (! $userId) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($userId);

        if (! $user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        return view('profile/show', ['user' => $user]);
    }

    public function edit()
    {
        $userId = session('user')['id'] ?? null;

        if (! $userId) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($userId);

        if (! $user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        return view('profile/edit', ['user' => $user]);
    }

    public function update()
    {
        $userId = session('user')['id'] ?? null;

        if (! $userId) {
            return redirect()->to('/login');
        }

        $currentUser = $this->userModel->find($userId);

        if (! $currentUser) {
            session()->destroy();
            return redirect()->to('/login');
        }

        $rules = [
            'name'       => 'required|min_length[3]|max_length[100]',
            'email'      => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'student_id' => 'permit_empty|max_length[20]',
            'course'     => 'permit_empty|max_length[100]',
            'year_level' => 'permit_empty|integer|greater_than[0]|less_than[6]',
            'section'    => 'permit_empty|max_length[50]',
            'phone'      => 'permit_empty|max_length[20]',
            'address'    => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'student_id' => $this->request->getPost('student_id'),
            'course'     => $this->request->getPost('course'),
            'year_level' => $this->request->getPost('year_level') ?: null,
            'section'    => $this->request->getPost('section'),
            'phone'      => $this->request->getPost('phone'),
            'address'    => $this->request->getPost('address'),
        ];

        $file = $this->request->getFile('profile_image');

        if ($file && $file->isValid() && ! $file->hasMoved()) {

            $imgRules = [
                'profile_image' => [
                    'rules'  => 'is_image[profile_image]'
                        . '|mime_in[profile_image,image/jpg,image/jpeg,image/png,image/webp]'
                        . '|max_size[profile_image,2048]',
                    'errors' => [
                        'is_image' => 'The file must be an image.',
                        'mime_in'  => 'Only JPG, PNG, and WEBP images are allowed.',
                        'max_size' => 'Image size must not exceed 2MB.',
                    ],
                ],
            ];

            if (! $this->validate($imgRules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            if (! empty($currentUser['profile_image'])) {
                $old = FCPATH . 'uploads/profiles/' . $currentUser['profile_image'];
                if (file_exists($old)) unlink($old);
            }

            $newName = 'avatar_' . $userId . '_' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/profiles/', $newName);
            $updateData['profile_image'] = $newName;
        }

        $this->userModel->updateProfile($userId, $updateData);

        // Update the nested session array so navbar shows new name immediately
        session()->set('user', array_merge(session('user'), [
            'name'  => $updateData['name'],
            'email' => $updateData['email'],
        ]));

        return redirect()->to('profile')
            ->with('success', 'Profile updated successfully!');
    }
}