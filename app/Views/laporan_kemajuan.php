<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/sidebar.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Link CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <script src="<?= base_url('js/animasi.js'); ?>"></script>
    <!-- Link JS DataTables dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <title>Laporan Kemajuan</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 220px;
            top: 0;
            width: calc(100% - 250px);
            height: 100%;
            overflow-y: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #f9f9f9;
            margin: 0;
            padding: 40px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 20px;
            right: 30px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        #laporanKemajuanForm {
            width: 100%;
            max-width: 100%;
        }

        #laporanKemajuanForm h2 {
            text-align: left;
            margin-top: 0;
        }

        #laporanKemajuanForm label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            text-align: left;
        }

        #laporanKemajuanForm input[type="text"],
        #laporanKemajuanForm input[type="date"],
        #laporanKemajuanForm input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 13px;
            box-sizing: border-box;
        }

        #laporanKemajuanForm button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 13px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        #laporanKemajuanForm button:hover {
            background-color: #0056b3;
        }

        #statusPencapaian {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 13px;
            box-sizing: border-box;
            font-size: 14;
            font-family: 'Montserrat';
        }
    </style>

    <!-- Script untuk langsung menerapkan dark mode jika statusnya disimpan di localStorage -->
    <script>
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode-variables');
        }
    </script>
</head>

<body>
    <div class="container">
        <?= $this->include('partials/sidebar'); ?>

        <main>
            <h1>Laporan Kemajuan</h1>
            <p>Ini adalah halaman untuk Laporan Kemajuan.</p>

            <button id="openModalBtn" style="margin-bottom: 20px; margin-top: 15px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 13px; cursor: pointer; font-family: 'Montserrat';">Tambah Laporan Kemajuan</button>

            <!-- Modal untuk form Laporan Kemajuan -->
            <div id="laporanKemajuanModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form id="laporanKemajuanForm" action="<?= base_url('Laporan Kemajuan/upload'); ?>" method="post" enctype="multipart/form-data">
                        <h2>Tambah Laporan Kemajuan</h2>

                        <label for="laporanKemajuanName">Judul Penelitian:</label>
                        <input type="text" id="laporanKemajuanName" name="laporanKemajuanName" placeholder="Masukkan nama Laporan Kemajuan" required>

                        <label for="statusPencapaian">Status Pencapaian:</label>
                        <select id="statusPencapaian" name="statusPencapaian" required>
                            <option value="pending">Pending</option>
                            <option value="sedang_dikerjakan">Sedang Dikerjakan</option>
                            <option value="selesai">Selesai</option>
                        </select>

                        <!-- dirubah -->
                        <label for="judulPenelitian">Hasil Sementara:</label>
                        <input type="text" id="judulPenelitian" name="judulPenelitian" placeholder="Masukkan judul penelitian" required>

                        <label for="deskripsiSingkat">Hambatan/Kendala:</label>
                        <textarea id="deskripsiSingkat" name="deskripsiSingkat" required></textarea>

                        <label for="latarBelakang">Rekomendasi atau Tindakan Lanjutan:</label>
                        <textarea id="latarBelakang" name="latarBelakang" required></textarea>

                        <label for="jadwalPenelitian">Tanggal Pembaruan:</label>
                        <input type="date" id="jadwalPenelitian" name="jadwalPenelitian" required>

                        <label for="berkas_proposal">File Laporan Kemajuan:</label>
                        <input type="file" name="berkas_proposal" id="berkas_proposal" required>

                        <button type="submit">Unggah</button>
                    </form>

                    <style>
                        textarea {
                            width: 100%;
                            height: 150px;
                            padding: 10px;
                            margin-top: 5px;
                            margin-bottom: 10px;
                            border: 1px solid #ccc;
                            border-radius: 13px;
                            box-sizing: border-box;
                            resize: none;
                        }
                    </style>


                </div>
            </div>

            <div class="recent-orders" style="width: 100%; height: auto; overflow-x: auto;">
                <h2>Daftar Laporan Kemajuan</h2>
                <table id="laporanKemajuanTable" class="display full-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan Kemajuan</th>
                            <th>Tanggal Laporan Kemajuan</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Contoh Judul Laporan Kemajuan 1</td>
                            <td>01/01/2024</td>
                            <td><a href="<?= base_url('uploads/Laporan Kemajuan1.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Contoh Judul Laporan Kemajuan 2</td>
                            <td>06/01/2024</td>
                            <td><a href="<?= base_url('uploads/Laporan Kemajuan2.pdf'); ?>" target="_blank">Unduh/Preview</a></td>
                            <td>
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            $('#laporanKemajuanTable').DataTable();

            var modal = document.getElementById("laporanKemajuanModal");
            var btn = document.getElementById("openModalBtn");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            // Menutup modal saat tombol 'X' diklik
            document.querySelector('.close').onclick = function() {
                document.getElementById('laporanKemajuanModal').style.display = 'none';
            };

            // Menutup modal jika pengguna mengklik di luar konten modal
            window.onclick = function(event) {
                const modal = document.getElementById('laporanKemajuanModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        });
    </script>
</body>

</html>