<?= $this->extend('main/layout') ?>


<?= $this->section('judul') ?>
Selamat Datang !
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>

<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-info"></i> Selamat Datang !</h5>
    Ini adalah aplikasi Inventory Gudang
</div>
<?= $this->endSection() ?>