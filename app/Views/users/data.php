<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen Users
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<button type="button" class="btn btn-sm btn-primary btnTambah">
    <i class="fa fa-plus"></i> Tambah User Baru
</button>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<table id="datauser" class="table table-bordered table-hover display" style="width: 100%">
    <thead>
        <tr>
            <th>No</th>
            <th>ID User</th>
            <th>Nama User</th>
            <th>Level</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<div class="viewmodal" style="display: none;"></div>

<script>
    $(document).ready(function() {
        dataUser = $('#datauser').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/users/listData',
            order: [],
            columns: [{
                    "data": "no",
                    "orderable": false,
                },
                {
                    "data": "userid"
                },
                {
                    "data": "usernama"
                },
                {
                    "data": "levelnama"
                },
                {
                    "data": "status"
                },
                {
                    "data": "aksi"
                }
            ],
            columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5],
                className: 'text-center'
            }, ],
        });

        $('.btnTambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "/users/formtambah",
                success: function(response) {
                    $('.viewmodal').html(response).show();
                    $('#modaltambah').modal('show');
                }
            });
        });
    });

    function view(userid) {
        $.ajax({
            type: "post",
            url: "/users/formedit",
            data: {
                userid: userid
            },
            success: function(response) {
                $('.viewmodal').html(response).show();
                $('#modaledit').modal('show');
            }
        });
    }
</script>

<?= $this->endSection() ?>