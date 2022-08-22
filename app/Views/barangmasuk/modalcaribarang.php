<!-- Modal -->
<div class="modal fade" id="modalcaribarang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Silahkan Cari Data Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Silahkan cari barang berdasarkan Kode/Nama" id="cari">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" id="btnCari">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <div class="row viewdetaildata"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function cariDataBarang(){
    let cari = $('#cari').val();

    $.ajax({
        type: "post",
        url: "/barangmasuk/detailCariBarang",
        data: {
            cari : cari
        },
        dataType: "json",
        beforeSend : function(){
            $('.viewdetaildata').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        success: function (response) {
            if (response.data){
                $('.viewdetaildata').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

$(document).ready(function () {
    $('#btnCari').click(function (e) { 
        e.preventDefault();

        cariDataBarang();
    });

    $('#cari').keydown(function (e) { 
        if (e.keyCode == 13){
            e.preventDefault();
            cariDataBarang();
        }
    });
});
</script>