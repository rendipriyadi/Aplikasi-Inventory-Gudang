<?php if (session()->userlevelid == 1) : ?>
    <li class="nav-header">Master</li>
    <li class="nav-item">
        <a href="<?= site_url('kategori/index') ?>" class="nav-link">
            <i class="nav-icon fa fa-angle-double-right text-warning"></i>
            <p class="text">Kategori</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= site_url('satuan/index') ?>" class="nav-link">
            <i class="nav-icon fa fa-tasks text-danger"></i>
            <p class="text">Satuan</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= site_url('barang/index') ?>" class="nav-link">
            <i class="nav-icon fa fa-tasks text-info"></i>
            <p class="text">Barang</p>
        </a>
    </li>
    <li class="nav-header">Transaksi</li>
    <li class="nav-item">
        <a href="<?= site_url('barangmasuk/data') ?>" class="nav-link">
            <i class="nav-icon fa fa-arrow-circle-down text-primary"></i>
            <p class="text">Barang Masuk</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= site_url('barangkeluar/data') ?>" class="nav-link">
            <i class="nav-icon fa fa-arrow-circle-up text-warning"></i>
            <p class="text">Barang Keluar</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= site_url('laporan/index') ?>" class="nav-link">
            <i class="nav-icon fa fa-file text-warning"></i>
            <p class="text">Laporan</p>
        </a>
    </li>
    <li class="nav-header">Utility</li>
    <li class="nav-item">
        <a href="<?= site_url('utility/index') ?>" class="nav-link">
            <i class="nav-icon fa fa-database text-warning"></i>
            <p class="text">BackUp DB</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= site_url('users/index') ?>" class="nav-link">
            <i class="nav-icon fa fa-users text-danger"></i>
            <p class="text">Management Users</p>
        </a>
    </li>
<?php endif; ?>
<?php if (session()->userlevelid == 2) : ?>
    <li class="nav-header">Transaksi</li>
    <li class="nav-item">
        <a href="<?= site_url('barangkeluar/data') ?>" class="nav-link">
            <i class="nav-icon fa fa-arrow-circle-up text-warning"></i>
            <p class="text">Barang Keluar</p>
        </a>
    </li>
<?php endif; ?>
<?php if (session()->userlevelid == 3) : ?>
    <li class="nav-header">Transaksi</li>
    <li class="nav-item">
        <a href="<?= site_url('barangmasuk/data') ?>" class="nav-link">
            <i class="nav-icon fa fa-arrow-circle-down text-primary"></i>
            <p class="text">Barang Masuk</p>
        </a>
    </li>
<?php endif; ?>
<li class="nav-item">
    <a href="<?= site_url('utility/gantipassword') ?>" class="nav-link">
        <i class="fa fa-lock nav-icon text-white"></i>
        <p class="text">Ganti Password</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= site_url('login/keluar') ?>" class="nav-link">
        <i class="fa fa-sign-out-alt nav-icon text-success"></i>
        <p class="text">Logout</p>
    </a>
</li>