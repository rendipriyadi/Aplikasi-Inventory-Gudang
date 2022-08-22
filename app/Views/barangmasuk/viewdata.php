<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Data Transaksi Barang Masuk
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
    <button type="button" class="btn btn-primary" onclick="window.location='<?= site_url('barangmasuk/index') ?>'">
        <i class="fa fa-plus-circle"></i> Input Transaksi
    </button>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<div class="card">
    <div class="card-body ">
        <table id="databarangmasuk" class="table table-bordered table-hover display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Faktur</th>
                    <th>Tanggal</th>
                    <th>Jumlah Item</th>
                    <th>Total Harga (Rp)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($databarang as $row) :
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['faktur']; ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tglfaktur'])) ; ?></td>
                        <td align="center">
                            <?php 
                                $db = \Config\Database::connect();
                                $jumlahItem = $db->table('detail_barangmasuk')->where('detfaktur', $row['faktur'])->countAllResults();
                            ?>
                            <span style="cursor: pointer; font-weight: bold; color: blue;" onclick="detailItem('<?= $row['faktur'] ?>')"><?= $jumlahItem; ?></span>
                        </td>
                        <td><?= number_format($row['totalharga'], 0, ",", "."); ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-info" title="Edit Transaksi" onclick="edit('<?= sha1($row['faktur']) ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            &nbsp;
                            <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi" onclick="hapusTransaksi('<?= $row['faktur'] ?>')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<script>
function hapusTransaksi(faktur){
    Swal.fire({
        title: 'Hapus Transaksi',
        text: "Yakin hapus transaksi ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/barangmasuk/hapusTransaksi",
                data: {
                    faktur : faktur
                },
                dataType: "json",
                success: function (response) {
                    if (response.sukses) {
                        Swal.fire({
                           icon: 'success',
                           title: 'Berhasil',
                           html: response.sukses
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });    
                    }
                },
                error: function(xhr, ajaxOptions, thrownError){
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
            });
        }
    })
}

function edit(faktur){
    window.location.href = ('/barangmasuk/edit/') + faktur;
}

function detailItem(faktur){
    $.ajax({
        type: "post",
        url: "/barangmasuk/detailItem",
        data: {
            faktur : faktur
        },
        dataType: "json",
        success: function (response) {
            if (response.data){
                $('.viewmodal').html(response.data).show();
                $('#modalitem').modal('show');
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

$(document).ready(function () {
    $('#databarangmasuk').DataTable();
   
});
</script>
<?= $this->endSection() ?>