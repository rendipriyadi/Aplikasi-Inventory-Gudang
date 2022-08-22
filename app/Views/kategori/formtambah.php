<?= $this->extend('main/layout') ?>


<?= $this->section('judul') ?>
Form Tambah Kategori
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>

<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('kategori/index'). "')"
    ]) ?>

<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('kategori/simpandata') ?>
<div class="form-group">
    <label for="namakategori">Nama Kategori</label>
    <?= form_input('namakategori', '', [
        'class' => 'form-control',
        'id' => 'namakategori',
        'autofucus' => true,
        'placeholder' => 'Isikan Nama Kategori'
    ]) ?> 
    
<?= session()->getFlashdata('errorNamaKategori') ?>
</div>

<div class="form-group">
    <?= form_submit('','Simpan', [
        'class' => 'btn btn-success'
    ]) ?>
</div>
<?= form_close() ?>
<?= $this->endSection() ?>