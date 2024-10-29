<?php

namespace App\Controllers;
use App\Models\RegisterLogin_Model;
date_default_timezone_set('Asia/Jakarta');


class ForgotPasswordController extends BaseController
{

    // Fungsi untuk menampilkan halaman forgot password
    public function forgotPassword()
    {
        return view('forgot_password');
    }

    public function newPassword()
    {
        $userModel = new RegisterLogin_Model();
        $email = session()->get('email_access');
        $token = session()->get('token');
        // Cek apakah email ada di database dan ambil OTP serta waktu kadaluwarsanya
        if($token) {
            $user = $userModel->where('email', $email)->first();
            $currentDateTime = new \DateTime(); // Waktu saat ini
            $otpExpirationDateTime = new \DateTime($user['otp_expiration']); // Waktu kadaluarsa OTP
            $data = [
                'currentDateTime' => $currentDateTime,
                'otpExpirationDateTime' => $otpExpirationDateTime,
                'userModel' => $userModel,
                'user' => $user,
            ];
        }
        if (!session()->has('email_access')) {
            return redirect()->to(base_url('register_login'));
        }
        // Jika OTP masih valid, tampilkan view password_baru
        return view('password_baru', $data);
    }

    public function processOTP()
    {
        // Lakukan pengecekan validitas email dan kirim link reset password (jika menggunakan email).
        $userModel = new RegisterLogin_Model();
        $email = $this->request->getPost('email');
        $userEmail = $userModel->where('email', $email)->first();
        if ($userEmail) {
            $email = \Config\Services::email();
            $otp = $this->generateUniqueOTP($userModel); // Generate unique OTP
            $otpExpiration = date("Y-m-d H:i:s", strtotime("+15 minutes")); // Set 15 minutes expiration time
            $userModel->update($userEmail['id'], [
                'otp' => $otp,
                'otp_expiration' => $otpExpiration,
            ]); 
            $emailMessage = 'Halo '.$userEmail['username'].'<br><br>'
                        . 'Anda sedang melakukan reset password<br><br>'
                        .'Kode OTP Anda '.$otp.''
                        .'<br>Silahkan klik link di bawah ini untuk reset password Anda !<br><br>'
                        .'<a href="'.base_url('password_baru').'">Klik di sini untuk reset password Anda</a><br><br>'                        
                        .'Terimakasih<br> Fortuna';                        
            $email->setTo($userEmail['email']);
            $email->setFrom('fortunateams3@gmail.com', 'Fortuna');
            $email->setSubject('Kode OTP');
            $email->setMessage($emailMessage);
            if($email->send()) {
                session()->set('email_access', $userEmail['email']);
                session()->set('token', true);
                return redirect()->to(base_url('forgot_password'));
            } else {
                $data = $email->printDebugger(['headers']);
                print_r($data);
            }
        }
        // Jika tidak menggunakan email, langsung alihkan ke halaman password_baru.php

        // Redirect ke halaman password baru
        // return redirect()->to(base_url('forgot_password'));
    }

    private function generateUniqueOTP($userModel)
    {
    do {
        $otp = mt_rand(100000, 999999); // Generate new OTP
        $exists = $userModel->where('otp', $otp)->first(); // Check if OTP already exists
    } while ($exists); // Loop until a unique OTP is found
    
    return $otp;
    }

    public function processNewPassword() {
        $userModel = new RegisterLogin_Model();
        $currentDateTime = new \DateTime(); // Waktu saat ini
        $kode_otp = $this->request->getPost('kode_otp');
        $new_password = $this->request->getPost('new_password');
        $confirm_password = $this->request->getPost('confirm_password');
        $verify = $userModel->where('otp', $kode_otp)->first();
        $otpExpirationDateTime = new \DateTime($verify['otp_expiration']); // Waktu kadaluarsa OTP
        if($verify) {
            if ($currentDateTime > $otpExpirationDateTime) {
                // Jika OTP sudah kadaluarsa, hapus OTP dan redirect ke forgot_password
                $userModel->update($verify['id'], [
                    'otp' => NULL,
                    'otp_expiration' => NULL, // Pastikan untuk menghapus juga kolom ini
                ]);
                session()->remove('email_access');
                session()->remove('token');
                return redirect()->to(base_url('forgot_password'));
            }
            // Pastikan array di dalam update() hanya berisi data yang akan diupdate
            else {
                $userModel->update($verify['id'], [
                    'password' => password_hash($new_password, PASSWORD_DEFAULT),
                    'otp' => NULL,
                    'otp_expiration' => NULL,
                ]); 
                session()->remove('email_access');
                session()->remove('token');
                return redirect()->to(base_url('register_login'));
            }
        } else {
            return redirect()->to(base_url('password_baru'));
        }
    }
}
