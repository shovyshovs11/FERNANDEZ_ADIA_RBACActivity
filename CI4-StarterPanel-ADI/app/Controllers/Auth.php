<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        //after login sa dashboard mapupunta
        if (session()->get('isLoggedIn') == TRUE) {
            return redirect()->to(base_url('dashboard'));
        }
        //checks kung nakapag input ng email
        if (!$this->validate(['inputEmail'  => 'required'])) {
        // login form diretso if walang email na nainput
            return view('pages/commons/login');
        } else {
        // lgin process here
            $inputEmail     = htmlspecialchars($this->request->getVar('inputEmail', FILTER_UNSAFE_RAW));
            $inputPassword  = htmlspecialchars($this->request->getVar('inputPassword', FILTER_UNSAFE_RAW));
            $user           = $this->ApplicationModel->getUser(username: $inputEmail);
            
            if ($user) {
                $password        = $user['password'];
                $verify = password_verify($inputPassword, $password);
                
                if ($verify) { // if correct password
                    session()->set([
                        'username'        => $user['username'],
                        'role'            => $user['role'],
                        'isLoggedIn'     => TRUE
                    ]);
                    return redirect()->to(base_url('dashboard'));

                } else { // if wrong password
                    session()->setFlashdata('notif_error', '<b>Your ID or Password is Wrong !</b> ');
                    return redirect()->to(base_url());
                }
            } else {
                session()->setFlashdata('notif_error', '<b>Your ID or Password is Wrong!</b> ');
                return redirect()->to(base_url());
            }
        }
    }


    public function logout()
    {
        $this->session->destroy(); // clears all session data
        return redirect()->to(base_url('/')); // back to login page
    }

    public function forbiddenPage()
    {
        $data = array_merge($this->data, [
            'title'         => 'Forbidden Page'
        ]);
        return view('pages/commons/forbidden', $data);
    }

    public function register()
    {
        return view('pages/commons/register');
    }

    public function registration()
    {
        // RULES AGAIN
        if (!$this->validate([
            'inputEmail'     => ['label' => 'Email', 'rules' => 'is_unique[users.username]'],
            'inputPassword'  => ['label' => 'Password', 'rules' => 'required'],
            'inputPassword2' => ['label' => 'Password Confirmation', 'rules' => 'matches[inputPassword]'],
        ])) {
            $data = array_merge($this->data, [
                'title'         => 'Register Page',
            ]);

            session()->setFlashdata('notif_error', $this->validation->getError('inputPassword2') . ' ' . $this->validation->getError('inputEmail'));
            return view('pages/commons/register', $data);
        } else {
            $inputFullname = htmlspecialchars($this->request->getVar('inputFullname', FILTER_UNSAFE_RAW));
            $inputEmail    = htmlspecialchars($this->request->getVar('inputEmail', FILTER_UNSAFE_RAW));
            $inputPassword = htmlspecialchars($this->request->getVar('inputPassword', FILTER_UNSAFE_RAW));
            $dataUser      = [
                'inputFullname' => $inputFullname,
                'inputUsername' => $inputEmail,
                'inputPassword' => $inputPassword,
                'inputRole'     => 1
            ];
            $this->ApplicationModel->createUser($dataUser);
            session()->setFlashdata('notif_success', '<b>Registration Successfully!</b> Please login with your account.');
            return view('pages/commons/login');
        }
    }
}
