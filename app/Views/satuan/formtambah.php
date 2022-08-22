<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Tambah Satuan
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-sm btn-warning" onclick="window.location='<?= site_url('satuan/index') ?>'">
    <i class="fa fa-backward"></i> Kembali
</button>

<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('', ['class' => 'formsimpan']) ?>
<?= csrf_field(); ?>
<div class="form-group">
    <label for="namasatuan">Nama Satuan</label>
    <input type="text" name="namasatuan" id="namasatuan" class="form-control" placeholder="Isikan Nama Satuan" autofocus>
    <div class="invalid-feedback errorNamaSatuan" style="display: none;">
    </div>
</div>

<div class="form-goup">
    <button type="submit" class="btn btn-success tombolSimpan">Simpan</button>
</div>
<?= form_close(); ?>

<script>
    $(document).ready(function() {
        $('.tombolSimpan').click(function(e) {
            e.preventDefault();

            let form = $('.formsimpan')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: "<?= site_url('satuan/simpandata') ?>",
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('.tombolSimpan').prop('disabled', true);
                },
                complete: function() {
                    $('.tombolSimpan').html('Simpan');
                    $('.tombolSimpan').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let dataError = response.error;
                        if (dataError.errorNamaSatuan) {
                            $('.errorNamaSatuan').html(dataError.errorNamaSatuan).show();
                            $('#namasatuan').addClass('is-invalid');
                        } else {
                            $('.errorNamaSatuan').fadeOut();
                            $('#namasatuan').removeClass('is-invalid');
                            $('#namasatuan').addClass('is-valid');
                        }
                    } else {
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
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>