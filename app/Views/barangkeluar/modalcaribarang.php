<!-- Modal -->
<div class="modal fade" id="modalcaribarang" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Cari Data Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table style="width: 100%;" id="databarang" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function pilih(kode){
    $('#kodebarang').val(kode);
    $('#modalcaribarang').on('hidden.bs.modal', function (event) {
        ambilDataBarang();
    });
    $('#modalcaribarang').modal('hide');
}
function listDataBarang(){
    var table = $('#databarang').DataTable({
        destroy : true,
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
            "url": "/barangkeluar/listDataBarang",
            "type": "POST",
        },
        "columnDefs" : [{
            "targets" : [0, 5],
            "orderable" : false,
        },],
    });
}

$(document).ready(function () {
    listDataBarang();
});
</script>