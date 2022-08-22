<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Tambah Barang
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-sm btn-warning" onclick="window.location='<?= site_url('barang/index') ?>'">
    <i class="fa fa-backward"></i> Kembali
</button>

<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open_multipart('barang/simpandata') ?>
<?= session()->getFlashdata('error') ?>
<?= session()->getFlashdata('sukses') ?>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Kode Barang</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="kodebarang" name="kodebarang" autofocus>
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Nama Barang</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="namabarang" name="namabarang">
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Pilih Kategori</label>
    <div class="col-sm-4">
        <select name="kategori" id="kategori" class="form-control">
            <option selected value="">=pilih=</option>
            <?php foreach($datakategori as $kat) :  ?>
                <option value="<?= $kat['katid'] ?>"><?= $kat['katnama'] ?></option>
            <?php endforeach; ?>    
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Pilih Satuan</label>
    <div class="col-sm-4">
        <select name="satuan" id="satuan" class="form-control">
            <option selected value="">=pilih=</option>
            <?php foreach($datasatuan as $sat) :  ?>
                <option value="<?= $sat['satid'] ?>"><?= $sat['satnama'] ?></option>
            <?php endforeach; ?>    
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Harga</label>
    <div class="col-sm-4">
        <input type="number" class="form-control" id="harga" name="harga">
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Stok</label>
    <div class="col-sm-4">
        <input type="number" class="form-control" id="stok" name="stok">
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Upload Gambar (<i>jika ada</i>)</label>
    <div class="col-sm-4">
        <input type="file" id="gambar" name="gambar">
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label"></label>
    <div class="col-sm-4">
        <input type="submit" value="Simpan" class="btn btn-success">
    </div>
</div>
<?= form_close(); ?>


<?= $this->endSection() ?>