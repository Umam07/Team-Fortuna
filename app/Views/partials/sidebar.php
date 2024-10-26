<aside>
    <div class="toggle">
        <div class="logo">
            <img src="<?= base_url('images/Logo Web Fortuna.png'); ?>" alt="Logo Web Fortuna">
            <h2>Penta<span class="web">Dosen</span></h2>
        </div>
        <div class="close" id="close-btn">
            <span class="material-icons-sharp">close</span>
        </div>
    </div>

    <div class="sidebar">
        <a href="<?= site_url('/dashboard'); ?>" class="<?= uri_string() == 'dashboard' ? 'active' : ''; ?>">
            <span class="material-icons-sharp">dashboard</span>
            <h3>Dashboard</h3>
        </a>
        <a href="<?= site_url('/kalender'); ?>" class="<?= uri_string() == 'kalender' ? 'active' : ''; ?>">
            <span class="material-icons-sharp">person_outline</span>
            <h3>Kalender</h3>
        </a>
        <a href="<?= site_url('/laporan_kemajuan'); ?>" class="<?= uri_string() == 'laporan_kemajuan' ? 'active' : ''; ?>">
            <span class="material-icons-sharp">receipt_long</span>
            <h3>Laporan Kemajuan</h3>
        </a>
        <a href="<?= site_url('/laporan_akhir'); ?>" class="<?= uri_string() == 'laporan_akhir' ? 'active' : ''; ?>">
            <span class="material-icons-sharp">insights</span>
            <h3>Laporan Akhir</h3>
        </a>
        <a href="<?= site_url('/publikasi'); ?>" class="<?= uri_string() == 'publikasi' ? 'active' : ''; ?>">
            <span class="material-icons-sharp">mail_outline</span>
            <h3>Publikasi</h3>
            <!-- <span class="message-count">1</span> -->
        </a>
        <a href="<?= site_url('/setting'); ?>" class="<?= uri_string() == 'setting' ? 'active' : ''; ?>">
            <span class="material-icons-sharp">settings</span>
            <h3>Setting</h3>
        </a>
        <a href="registerlogincontroller/logout">
            <span class="material-icons-sharp">
                logout
            </span>
            <h3>Logout</h3>
        </a>

    </div>
</aside>