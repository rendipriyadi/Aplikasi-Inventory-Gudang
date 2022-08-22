<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Cek Transaksi Status Midtrans
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
    <button type="button" class="btn btn-warning" onclick="window.location='<?= site_url('barangkeluar/data') ?>'">
        <i class="fa fa-plus-backward"></i> Kembali
    </button>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<table class="table table-sm table-striped">
    <tr>
        <td style="width: 30%; text-align: left;">No. Faktur</td>
        <td style="width: 2%;">:</td>
        <td><?= $nofaktur; ?></td>
    </tr>
    <tr>
        <td>Tgl. Faktur</td>
        <td>:</td>
        <td><?= $tglfaktur; ?></td>
    </tr>
    <tr>
        <td>Nama Pelanggan</td>
        <td>:</td>
        <td><?= $namapelanggan; ?></td>
    </tr>
    <tr>
        <td>No. Tlp Pelanggan</td>
        <td>:</td>
        <td><?= $telp; ?></td>
    </tr>
    <tr>
        <td>Order ID</td>
        <td>:</td>
        <td><?= $orderid; ?></td>
    </tr>
    <tr>
        <td>Status Transaksi</td>
        <td>:</td>
        <td>
            <?php 
                if ($status_transaksi == 'pending') {
                    echo '<span class="badge bg-gray">Pending</span>';
                }else if ($status_transaksi == 'settlement') {
                    echo '<span class="badge badge-success">Sukses Pembayaran</span>';
                }else{
                    echo '<span class="badge badge-danger">Expired</span>';
                }
            ?>
        </td>
    </tr>
</table>
<?= $this->endSection() ?>