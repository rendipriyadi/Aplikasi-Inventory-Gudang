<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Utility System
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
Backup Database
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= session()->getFlashdata('pesan') ?>
<button type="button" class="btn btn-primary" onclick="location.href=('/utility/doBackup')">
    CLick To Backup Database
</button>
<?= $this->endSection() ?>