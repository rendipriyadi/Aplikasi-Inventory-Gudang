<div class="modal fade" id="modaltambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('users/simpan', ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">ID User :</label>
                    <input type="text" name="iduser" id="iduser" class="form-control form-control-sm" autocomplete="off">
                    <div class="invalid-feedback errorIdUser" style="display: none;">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Lengkap :</label>
                        <input type="text" name="namalengkap" id="namalengkap" class="form-control form-control-sm" autocomplete="off">
                        <div class="invalid-feedback errorNamaLengkap" style="display: none;">
                        </div>
                        <div class="form-group">
                            <label for="">Level User :</label>
                            <select name="level" id="level" class="form-control form-control-sm">
                                <option value="" selected> --Pilih Level User-- </option>
                                <?php foreach ($datalevel->getResultArray() as $l) : ?>
                                    <option value="<?= $l['levelid'] ?>"><?= $l['levelnama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorLevel" style="display: none;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success tombolSimpan">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('.formsimpan').submit(function(e) {
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
                                $('.tombolSimpan').html('Simpan');
                                $('.tombolSimpan').prop('disabled', false);
                            },
                            success: function(response) {
                                if (response.error) {
                                    if (response.error.errorIdUser) {
                                        $('.errorIdUser').html(response.error.errorIdUser).show();
                                        $('#iduser').addClass('is-invalid');
                                    } else {
                                        $('.errorIdUser').fadeOut();
                                        $('#iduser').removeClass('is-invalid');
                                        $('#iduser').addClass('is-valid');
                                    }
                                    if (response.error.errorNamaLengkap) {
                                        $('.errorNamaLengkap').html(response.error.errorNamaLengkap).show();
                                        $('#namalengkap').addClass('is-invalid');
                                    } else {
                                        $('.errorNamaLengkap').fadeOut();
                                        $('#namalengkap').removeClass('is-invalid');
                                        $('#namalengkap').addClass('is-valid');
                                    }
                                    if (response.error.errorLevel) {
                                        $('.errorLevel').html(response.error.errorLevel).show();
                                        $('#level').addClass('is-invalid');
                                    } else {
                                        $('.errorLevel').fadeOut();
                                        $('#level').removeClass('is-invalid');
                                        $('#level').addClass('is-valid');
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        html: response.sukses
                                    });
                                    $('#modaltambah').modal('hide');
                                    dataUser.ajax.reload();
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    });
                });
            </script>