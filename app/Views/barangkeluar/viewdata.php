<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Data Transaksi Barang Keluar
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
    <button type="button" class="btn btn-primary" onclick="window.location='<?= site_url('barangkeluar/input') ?>'">
        <i class="fa fa-plus-circle"></i> Input Transaksi
    </button>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<div class="row">
    <div class="col">
        <label for="">Filter Data</label>
    </div>
    <div class="col">
        <input type="date" name="tglawal" id="tglawal" class="form-control">
    </div>
    <div class="col">
        <input type="date" name="tglakhir" id="tglakhir" class="form-control">
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-primary" id="tombolTampil"> Tampilkan</button>
    </div>
</div>
<br>
<table style="width: 100%;" id="databarangkeluar" class="table table-bordered table-hover dataTable dtr-inline collapsed">
    <thead>
        <tr>
            <th>No</th>
            <th>Faktur</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Payment<br>Method</th>
            <th>Status</th>
            <th>Total Harga (Rp)</th>
            <th width="100px">Aksi</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script>
function cektransaksi(faktur){
    window.location.href = '/barangkeluar/cektransaksi/' + faktur;
}

function listDataBarangKeluar(){
    var table = $('#databarangkeluar').DataTable({
        destroy : true,
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
            "url": "/barangkeluar/listData",
            "type": "POST",
            "data" : {
                tglawal : $('#tglawal').val(),
                tglakhir : $('#tglakhir').val(),
            },
        },
        "columnDefs" : [{
            "targets" : [0, 5],
            "orderable" : false,
        },],
    });
}

function cetak(faktur) {
    let windowCetak = window.open('/barangkeluar/cetakfaktur/'+faktur, "Cetak Faktur Barang Keluar", "width=400,height=400");

    windowCetak.focus();
}

function hapus(faktur) {
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
                url: "/barangkeluar/hapusTransaksi",
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

$(document).ready(function () {
    listDataBarangKeluar();

    $('#tombolTampil').click(function (e) { 
        e.preventDefault();
        
        listDataBarangKeluar();
    });
});

function edit(faktur){
    window.location.href=('/barangkeluar/edit/') + faktur;
}
</script>
<?= $this->endSection() ?>