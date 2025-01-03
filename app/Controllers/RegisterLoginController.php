<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegisterLogin_Model;

class RegisterLoginController extends BaseController
{
    public function index()
    {
        helper('form');
        // Load the registration form view
        return view('register_login');
    }

    public function processRegister()
    {

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'password'  => 'required|min_length[6]'
        ]);

        $valid = $this->validate([
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'min_length[6]' => '{field} minimal 6 huruf',
                ],
            ],
        ]);

        if (!$valid) {
            $sessError = [
                'errPasswordRegister' => $validation->getError('password'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(base_url('registerlogincontroller/index'));
        }

        // Simpan data ke database
        $userModel = new RegisterLogin_Model();
        $username = $userModel->where('username', $this->request->getPost('username'))->first();
        $userEmail = $userModel->where('email', $this->request->getPost('email'))->first();

        if ($username || $userEmail) {
            if ($username) {
                $sessError = [
                    'errUsernameRegister' => 'Maaf Username sudah terdaftar !',
                ];
                session()->setFlashdata($sessError);
            }
            if ($userEmail) {
                $sessError = [
                    'errEmail' => 'Maaf Email Sudah terdaftar !',
                ];
                session()->setFlashdata($sessError);
            }
            return redirect()->back();
        }

        $result = $userModel->save([
            'nama'               => $this->request->getPost('nama'),
            'nidn'               => $this->request->getPost('nidn'),
            'nip'                => $this->request->getPost('nip'),
            'inisial_nama'       => $this->request->getPost('nama_inisial'),
            'jabatan_akademik'   => $this->request->getPost('jabatan_akademik'),
            'perguruan_tinggi'   => $this->request->getPost('perguruan_tinggi'),
            'fakultas'           => $this->request->getPost('fakultas'),
            'program_studi'      => $this->request->getPost('program_studi'),
            'email'              => $this->request->getPost('email'),
            'username'           => $this->request->getPost('username'),
            'password'           => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'user_type'          => 'dosen',
        ]);

        if ($result === false) {
            echo "Data gagal disimpan. Kesalahan: " . implode(', ', $userModel->errors());
        } else {
            echo "Data berhasil disimpan!";
            // Redirect ke halaman login setelah sukses
            return redirect()->to('register_login')->with('success', 'Registrasi berhasil, silakan login.');
        }
    }

    public function processLogin()
    {
        // Handle the form submission for login
        // Ambil data dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input (validasi sederhana, bisa disesuaikan dengan kebutuhan)
        // if (empty($username) || empty($password)) {
        //     return redirect()->back()->withInput()->with('error', 'All fields are required.');
        // }
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ],
            ],
        ]);

        if (!$valid) {
            $sessError = [
                'errUsernameLogin' => $validation->getError('username'),
                'errPasswordLogin' => $validation->getError('password'),
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(base_url('registerlogincontroller/index'));
        } else {
            // Inisialisasi model
            $loginModel = new RegisterLogin_Model();
            // Cek apakah username ada di database
            $user = $loginModel->where('username', $username)->first();
            if ($user == null) {
                // Jika username tidak ditemukan
                $sessError = [
                    'errUsernameLogin' => 'Maaf Username salah !',
                ];
                session()->setFlashdata($sessError);
                return redirect()->to(base_url('register_login'));
            } else {
                if (password_verify($password, $user['password'])) {
                    // Jika login berhasil, set session untuk user
                    session()->set([
                        'user_id'   => $user['id'],
                        'username' => $user['username'],
                        'logged_in' => true,
                        'nama'      => $user['nama'],
                        'user_type' => $user['user_type'] // untuk mengatur role
                    ]);
                    // Redirect ke halaman dashboard atau halaman lain setelah login sukses
                    return redirect()->to('dashboard');
                } else {
                    // Jika password salah
                    $sessError = [
                        'errPasswordLogin' => 'Maaf Password salah !',
                    ];
                    session()->setFlashdata($sessError);
                    return redirect()->to(base_url('register_login'));
                }
            }
        }
        // // Inisialisasi model
        // $loginModel = new RegisterLogin_Model();

        // // Cek apakah username ada di database
        // $user = $loginModel->where('username', $username)->first();

        // if ($user) {
        //     // Verifikasi password
        //     if (password_verify($password, $user['password'])) {
        //         // Jika login berhasil, set session untuk user
        //         session()->set([
        //             'username' => $user['username'],
        //             'logged_in' => true,
        //             'user_type' => $user['user_type'] // Misalnya untuk mengatur role
        //         ]);
        //         // Redirect ke halaman dashboard atau halaman lain setelah login sukses
        //         return redirect()->to('/dashboard')->with('success', 'Login successful.');

        //     } else {
        //         // Jika password salah
        //         return redirect()->back()->with('error', 'Invalid password.');
        //     }
        // } else {
        //     // Jika username tidak ditemukan
        //     return redirect()->back()->with('error', 'Username not found.');
        // }
    }

    public function logout()
    {
        session()->remove('user_id');
        session()->remove('logged_in');
        session()->remove('username');
        session()->remove('nama');
        session()->remove('user_type');
        return redirect()->to(base_url('register_login'));
    }

    public function forgotPassword()
    {
        if ($this->request->getPost('email')) {
            $otp = rand(100000, 999999); // Angka 6 digit

        }
    }
    public function newPassword() {}
}
