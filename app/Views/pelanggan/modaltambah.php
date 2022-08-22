<!-- Modal -->
<div class="modal fade" id="modaltambahpelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaltambahpelangganLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Form Input Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('pelanggan/simpan', ['class' => 'formsimpan']) ?>
        <div class="form-group">
            <label for="">Input Nama Pelanggan</label>
            <input type="text" name="namapel" id="namapel" class="form-control">
            <div class="invalid-feedback errNamaPelanggan"></div>
        </div>
        <div class="form-group">
            <label for="">No Telp/Hp</label>
            <input type="text" name="telp" id="telp" class="form-control">
            <div class="invalid-feedback errTelp"></div>
        </div>
        <div class="form-group">
            <label for=""></label>
            <button type="submit" class="btn btn-block btn-success " id="tombolsimpan">
                Simpan
            </button>
        </div>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    $('.formsimpan').submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#tombolsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                $('#tombolsimpan').prop('disabled', true);
            },
            complete: function() {
                $('#tombolsimpan').html('Simpan');
                $('#tombolsimpan').prop('disabled', false);
            },
            success: function (response) {
                if (response.error){
                    let err = response.error;

                    if(err.errNamaPelanggan){
                        $('#namapel').addClass('is-invalid');
                        $('.errNamaPelanggan').html(err.errNamaPelanggan);
                    }
                    if(err.errTelp){
                        $('#telp').addClass('is-invalid');
                        $('.errTelp').html(err.errTelp);
                    }
                }

                if (response.sukses){
                    Swal.fire({
                        title: 'Berhasil',
                        text: response.sukses,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Ambil!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#namapelanggan').val(response.namapelanggan);
                            $('#idpelanggan').val(response.idpelanggan);
                            $('#modaltambahpelanggan').modal('hide');
                        }else{
                            $('#modaltambahpelanggan').modal('hide');
                        }
                    })
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
        
        return false;
    });
});
</script>