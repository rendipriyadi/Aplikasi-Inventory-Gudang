<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen Data Satuan
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<button type="button" class="btn btn-primary" onclick="window.location='<?= site_url('satuan/formtambah') ?>'">
    <i class="fa fa-plus-circle"></i> Tambah Satuan
</button>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<div class="card">
    <div class="card-body ">
        <table id="datasatuan" class="table table-bordered table-hover display">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Satuan</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 1;
                foreach ($datasatuan as $row) :
                ?>
                    <tr>
                        <td><?= $nomor++; ?></td>
                        <td><?= $row['satnama']; ?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" title="Edit Kategori" onclick="window.location='/satuan/edit/<?= $row['satid'] ?>'">
                                <i class="fa fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" title="Hapus Kategori" onclick="hapus('<?= $row['satid'] ?>','<?= $row['satnama'] ?>')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datasatuan').DataTable();

    });

    function hapus(id, nama) {
        Swal.fire({
            title: 'Hapus Satuan',
            html: `Yakin hapus nama satuan <strong>${nama}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('satuan/hapus') ?>",
                    data: {
                        idsatuan: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'Berhasil',
                                title: 'Berhasil',
                                html: response.sukses
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    }
</script>
<?= $this->endSection() ?>