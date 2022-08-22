<!-- Modal -->
<div class="modal fade" id="modaldatapelanggan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaldatapelangganLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cari Data Pelanggan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table style="width: 100%;" id="datapelanggan" class="table table-bordered table-hover dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>No Telp/Hp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
<script>
function listDataPelanggan(){
    var table = $('#datapelanggan').DataTable({
        destroy : true,
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
            "url": "/pelanggan/listData",
            "type": "POST",
        },
        "columnDefs" : [{
            "targets" : [0],
            "orderable" : false,
        },],
    });
}

function pilih(id,nama){
    $('#namapelanggan').val(nama);
    $('#idpelanggan').val(id);

    $('#modaldatapelanggan').modal('hide');
}

function hapus(id,nama){
    Swal.fire({
        title: 'Hapus Pelanggan?',
        text: "Yakin menghapus data pelanggan dengan nama " + nama + " ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/pelanggan/hapus",
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {
                    if (response.sukses){
                        Swal.fire({
                            icon : 'success',
                            title : 'Hapus Data',
                            text : response.sukses
                        });

                        listDataPelanggan();
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
    listDataPelanggan();
});
</script>