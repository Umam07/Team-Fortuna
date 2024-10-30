<?php
if (!session()->get('logged_in')):
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <!-- Memuat style.css dari folder public -->
        <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
        <title>Registrasi</title>
    </head>

    <body>
        <div class="container" id="container">
            <div class="form-container sign-up">
                <?= form_open('registerlogincontroller/processRegister'); ?>
                <h1>Lengkapi Data</h1>
                <input type="text" name="nama" placeholder="Nama" required>
                <input type="text" name="nama_inisial" placeholder="Inisial Nama" required>
                <select name="program_studi" required>
                    <option value="" disabled selected>Pilih Nama Prodi</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Perpustakaan dan Sains Informasi">Perpustakaan dan Sains Informasi</option>
                </select>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="username" placeholder="Username" required>
                <?php  
                    if (session()->getFlashdata('errUsernameRegister')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            '.session()->getFlashdata('errUsernameRegister').'
                        </div>';
                    }
                ?>
                <input type="password" name="password" placeholder="Password" required>
                <?php  
                    if (session()->getFlashdata('errors')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            '.session()->getFlashdata('errors')['password'].'
                        </div>';
                    }
                ?>
                <button type="submit">Daftar</button>
                <?= form_close(); ?>
            </div>
            <div class="form-container sign-in">
                <?php
                if (session()->getFlashdata('errUsernameLogin')) {
                    $isInvalidUser = 'is-invalid';
                } else {
                    $isInvalidUser = '';
                }
                ?>
                <?= form_open('registerlogincontroller/processLogin'); ?>
                <?php  
                    if (session()->getFlashdata('gmailC')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            '.session()->getFlashdata('gmailC').'
                        </div>';
                    }
                ?>
                <?php  
                    if (session()->getFlashdata('berhasil')) {
                        echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            '.session()->getFlashdata('berhasil').'
                        </div>';
                    }
                ?>
                <h1>Login</h1>
                <input type="text" name="username" placeholder="Username">
                <?php
                if (session()->getFlashdata('errUsernameLogin')) {
                    echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            ' . session()->getFlashdata('errUsernameLogin') . '
                        </div>';
                }
                ?>
                <?php
                if (session()->getFlashdata('errPasswordLogin')) {
                    $isInvalidUser = 'is-invalid';
                } else {
                    $isInvalidUser = '';
                }
                ?>
                <input type="password" name="password" placeholder="Password">
                <?php
                if (session()->getFlashdata('errPasswordLogin')) {
                    echo '<div id="validationServer03Feedback" class="invalid-feedback">
                            ' . session()->getFlashdata('errPasswordLogin') . '
                        </div>';
                }
                ?>
                <a href="<?= base_url('/forgot_password'); ?>">Forgot Your Password?</a>
                <button type="submit">Login</button>
                <?= form_close(); ?>
            </div>
            <div class="toggle-container">
                <div class="toggle">
                    <div class="toggle-panel toggle-left">
                        <h1>Selamat Datang WAK!</h1>
                        <p>Masukkan detail pribadi awak untuk menggunakan situs ini</p>
                        <button class="hidden" id="login">Login</button>
                    </div>
                    <div class="toggle-panel toggle-right">
                        <h1>Hallo, WAK!</h1>
                        <p>Daftarkan detail pribadi awak untuk menggunakan situs ini</p>
                        <button class="hidden" id="register">Daftar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Memuat script.js dari folder public -->
        <script src="<?= base_url('js/script.js') ?>"></script>
    </body>

    </html>
<?php else: ?>
    <script>
        window.location.href = "<?= base_url('dashboard'); ?>";
    </script>
<?php endif; ?>