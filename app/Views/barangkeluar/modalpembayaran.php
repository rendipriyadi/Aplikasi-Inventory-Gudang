<!-- Modal -->
<div class="modal fade" id="modalpembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalpembayaranLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Pembayaran Faktur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('barangkeluar/simpanPembayaran', ['class' => 'frmpembayaran']) ?>
      <div class="modal-body">
        <div class="form-group">
            <label for="">No. Faktur</label>
            <input type="text" name="nofaktur" id="nofaktur" class="form-control" value="<?= $nofaktur ?>" readonly>
            <input type="hidden" name="tglfaktur" value="<?= $tglfaktur; ?>">
            <input type="hidden" name="idpelanggan" value="<?= $idpelanggan; ?>">
        </div>
        <div class="form-group">
            <label for="">Total Harga</label>
            <input type="text" name="totalbayar" id="totalbayar" class="form-control" value="<?= $totalharga ?>" readonly>
        </div>
        <div class="form-group">
            <label for="">Jumlah Uang</label>
            <input type="text" name="jumlahuang" id="jumlahuang" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="">Sisa Uang</label>
            <input type="text" name="sisauang" id="sisauang" class="form-control" readonly>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success btnSimpan">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>
<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>
<script>
$(document).ready(function () {
    $('#totalbayar').autoNumeric('init', {
        mDec : 0,
        aDec: ',',
        aSep : '.'
    });
    $('#jumlahuang').autoNumeric('init', {
        mDec : 0,
        aDec: ',',
        aSep : '.'
    });
    $('#sisauang').autoNumeric('init', {
        mDec : 0,
        aDec: ',',
        aSep : '.'
    });
    
    $('#jumlahuang').keyup(function (e) { 
       let totalbayar = $('#totalbayar').autoNumeric('get');
       let jumlahuang = $('#jumlahuang').autoNumeric('get');

       let sisauang;

       if (parseInt(jumlahuang) < parseInt(totalbayar)){
           sisauang = 0;
       }else{
           sisauang = parseInt(jumlahuang) - parseInt(totalbayar);
       }

       $('#sisauang').autoNumeric('set', sisauang);
    });

    $('.frmpembayaran').submit(function (e) { 
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btnSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                $('.btnSimpan').prop('disabled', true);
            },
            complete: function() {
                $('.btnSimpan').html('Simpan');
                $('.btnSimpan').prop('disabled', false);
            },
            success: function (response) {
                if (response.sukses) {
                    Swal.fire({
                        title: 'Cetak Faktur',
                        text: response.sukses+",cetak faktur ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Cetak !',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let windowCetak = window.open(response.cetakfaktur, "Cetak faktur barang keluar", "width=400,height=400");

                            windowCetak.focus();
                            window.location.reload();
                        }else{
                            window.location.reload();
                        }
                    });
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