<?= $this->extend('main/layout') ?>


<?= $this->section('judul') ?>
Manajemen Data Barang
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
    <button type="button" class="btn btn-primary" onclick="window.location='<?= site_url('barang/tambah') ?>'">
        <i class="fa fa-plus-circle"></i> Tambah Barang
    </button>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= session()->getFlashdata('error') ?>
<?= session()->getFlashdata('sukses') ?>
<div class="card">
    <div class="card-body ">
        <table id="databarang" class="table table-bordered table-hover display">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $nomor = 1 ;
                    foreach ($tampildata->getResultArray() as $row) :
                    ?>
                    <tr>
                        <td><?= $nomor++; ?></td>
                        <td><?= $row['brgkode']; ?></td>
                        <td><?= $row['brgnama']; ?></td>
                        <td><?= $row['katnama']; ?></td>
                        <td><?= $row['satnama']; ?></td>
                        <td><?= number_format($row['brgharga'],0); ?></td>
                        <td><?= number_format($row['brgstok'], 0); ?></td>
                        <td>
                        <button type="button" class="btn btn-sm btn-info" onclick="edit('<?= $row['brgkode'] ?>')">
                        <i class="fa fa-edit"></i>
                        </button> 

                        <form method="POST" action="/barang/hapus/<?= $row['brgkode'] ?>" style="display: inline;" onsubmit="return hapus()">
                            <input type="hidden" value="DELETE" name="_method">
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#databarang').DataTable();
   
});

function edit(kode){
    window.location.href = ('/barang/edit/' + kode);
}

function hapus(kode){
    pesan = confirm('Yakin data barang dihapus ?');

    if (pesan){
        return true;
    }else{
        return false;
    }
}

</script>
<?= $this->endSection() ?>