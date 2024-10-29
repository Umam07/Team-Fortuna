<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css'); ?>">
    <title>laporan Akhir</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar Section -->
        <!-- Bisa meng-include file sidebar yang sama -->
        <?= $this->include('partials/sidebar'); ?>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Laporan Akhir</h1>
            <p>Ini adalah halaman untuk laporan akhir.</p>
                
            <!-- Section untuk Tombol Unggah -->
            <div class="upload-section">
                <form action="<?= base_url('laporan Akhir/upload'); ?>" method="post" enctype="multipart/form-data">
                    <input type="file" name="berkas_laporan Akhir" required>
                    <button type="submit">Unggah</button>
                </form>
            </div>

            <!-- Tabel laporan Akhir -->
            <div class="recent-orders" style="width: 100%; height: auto; overflow-x: auto;">
                <h2>Daftar laporan Akhir</h2>
                <table class="full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul laporan Akhir</th>
                            <th>Tanggal laporan Akhir</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Data laporan Akhir -->
                        <tr>
                            <td>1</td>
                            <td>Contoh Judul laporan Akhir 1</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/laporan Akhir1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Contoh Judul laporan Akhir 2</td>
                            <td>06/01/2024</td>
                            <td><a href="<?= base_url('uploads/laporan Akhir2.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <!-- Tambahkan baris sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
            <!-- End of laporan Akhir Table -->
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Fortuna</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="Logo Web Fortuna">
                    </div>
                </div>
            </div>
            <!-- End of Nav -->

        </div>

        <script src="<?= base_url('js/index.js') ?>"></script>
</body>

</html>