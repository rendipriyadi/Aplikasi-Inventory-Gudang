<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Ganti Password
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>

<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('utility/updatepassword', ['class' => 'formupdatepassword']) ?>
<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">Password Lama :</label>
    <div class="col-sm-4">
        <input type="password" class="form-control" name="passlama" id="passlama">
        <div class="invalid-feedback errorPassLama" style="display: none;"></div>
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">Password Baru :</label>
    <div class="col-sm-4">
        <input type="password" class="form-control" name="passbaru" id="passbaru">
        <div class="invalid-feedback errorPassBaru" style="display: none;"></div>
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">Confirm Password Baru :</label>
    <div class="col-sm-4">
        <input type="password" class="form-control" name="confirmpass" id="confirmpass">
        <div class="invalid-feedback errorConfirmPass" style="display: none;"></div>
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
        <button type="submit" class="btn btn-success tombolSimpan">Ganti Password</button>
    </div>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('.formupdatepassword').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                    $('.tombolSimpan').prop('disabled', true);
                },
                complete: function() {
                    $('.tombolSimpan').html('Ganti Password');
                    $('.tombolSimpan').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.errorPassLama) {
                            $('.errorPassLama').html(response.error.errorPassLama).show();
                            $('#passlama').addClass('is-invalid');
                        } else {
                            $('.errorPassLama').fadeOut();
                            $('#passlama').removeClass('is-invalid');
                            $('#passlama').addClass('is-valid');
                        }
                        if (response.error.errorPassBaru) {
                            $('.errorPassBaru').html(response.error.errorPassBaru).show();
                            $('#passbaru').addClass('is-invalid');
                        } else {
                            $('.errorPassBaru').fadeOut();
                            $('#passbaru').removeClass('is-invalid');
                            $('#passbaru').addClass('is-valid');
                        }
                        if (response.error.errorConfirmPass) {
                            $('.errorConfirmPass').html(response.error.errorConfirmPass).show();
                            $('#confirmpass').addClass('is-invalid');
                        } else {
                            $('.errorConfirmPass').fadeOut();
                            $('#confirmpass').removeClass('is-invalid');
                            $('#confirmpass').addClass('is-valid');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: response.sukses
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = '/login/keluar';
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