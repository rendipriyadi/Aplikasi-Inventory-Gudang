<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<div class="modal fade" id="modaledit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">View Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('users/update', ['class' => 'formupdate']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">ID User :</label>
                    <input type="text" name="iduser" id="iduser" class="form-control form-control-sm" autocomplete="off" value="<?= $iduser ?>" readonly="true">
                </div>
                <div class="form-group">
                    <label for="">Nama Lengkap :</label>
                    <input type="text" name="namalengkap" id="namalengkap" class="form-control form-control-sm" autocomplete="off" value="<?= $namalengkap ?>">
                </div>
                <div class="form-group">
                    <label for="">Level User :</label>
                    <select name="level" id="level" class="form-control form-control-sm">
                        <option value="" selected> --Pilih Level User-- </option>
                        <?php foreach ($datalevel->getResultArray() as $l) : ?>
                            <?php if ($l['levelid'] == $level) : ?>
                                <option selected value="<?= $l['levelid'] ?>" selected><?= $l['levelnama'] ?></option>
                            <?php else : ?>
                                <option value="<?= $l['levelid'] ?>"><?= $l['levelnama'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Status User :</label>
                    <input type="checkbox" <?= ($status == '1') ? 'checked' : ''; ?> data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" data-onstyle="success" data-offstyle="danger" data-width="150" data-size="xs" class="chStatus">
                </div>
                <div class="form-group viewResetPassword" style="display: none;">
                    <label for="">Password Baru Anda :</label>
                    <br>
                    <h3 class="passReset"></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-purple btnreset">
                        <i class="fa fa-recycle"> Reset Password</i>
                    </button>
                    <button type="button" class="btn btn-danger btnhapus">
                        <i class="fa fa-trash-alt"> Hapus</i>
                    </button>
                    <button type="submit" class="btn btn-success tombolSimpan">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.btnreset').click(function(e) {
                e.preventDefault();
                let iduser = $('#iduser').val();

                Swal.fire({
                    title: 'Reset Password',
                    html: `Yakin Reset Password ID User <strong>${iduser}</strong> ini ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya,Reset !',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "/users/resetPassword",
                            data: {
                                iduser: iduser
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses == '') {
                                    $('.viewResetPassword').show();
                                    $('.passReset').html(response.passwordBaru);
                                }
                            },
                            error: function(xhr, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }
                })

            });

            $('.btnhapus').click(function(e) {
                e.preventDefault();
                let iduser = $('#iduser').val();

                Swal.fire({
                    title: 'Hapus User',
                    html: `Yakin hapus ID User <strong>${iduser}</strong> ini ?`,
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
                            url: "/users/hapus",
                            data: {
                                iduser: iduser
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses) {
                                    Swal.fire({
                                        icon: 'Berhasil',
                                        title: 'Berhasil',
                                        html: response.sukses
                                    });
                                    $('#modaledit').modal('hide');
                                    dataUser.ajax.reload();
                                }
                            },
                            error: function(xhr, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }
                })

            });

            $('.chStatus').change(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/users/updateStatus",
                    data: {
                        iduser: $('#iduser').val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses == '') {
                            dataUser.ajax.reload();
                        }
                    }
                });
            });

            $('.formupdate').submit(function(e) {
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
                        $('.tombolSimpan').html('Update');
                        $('.tombolSimpan').prop('disabled', false);
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: response.sukses
                        });
                        $('#modaledit').modal('hide');
                        dataUser.ajax.reload();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });
        });
    </script>