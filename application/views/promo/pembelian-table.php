<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Produk</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <?php $this->load->view('partials/head'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php $this->load->view('includes/nav'); ?>

  <?php $this->load->view('includes/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">Daftar Produk</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  

     <!-- Main content -->
     <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
          <a href="<?= base_url('promo/addPembelian/'); ?>"><button class="btn btn-success">Add</button></a>
          </div>
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="promo">
              <thead>
              <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Deskripsi</th>
                  <th>Potongan</th>
                  <th>Durasi</th>
                  <th>Status</th>
                  <th>Action</th>
                  
              </tr>
              </thead>
            </table>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>

<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
  const readUrl = '<?= base_url('promo/read/perbeli') ?>'
</script>
<script >
    let promo = $("#promo").DataTable({
    responsive: true,
    scrollX: true,
    ajax: readUrl,
    columnDefs: [{
        searcable: false,
        orderable: false,
        targets: 0
    }],
    order: [
        [1, "asc"]
    ],
    columns: [
        { data: null }, 
        { data: "nama" },
        { data: "deskripsi" },
        { 
          // data: "potongan" 
          render: function ( data, type, full, meta ) {
          return `${full.potongan} (${full.jenis =='rp' ? 'rp' : '%'})`
          }
        },
        { data: "durasi" },
        { data: "status" },
        { 
          render: function ( data, type, full, meta ) {
            return `
              <a href=<?= base_url('promo/editbeli/') ?>${full.id} class="btn btn-success" role="button">Edit</a>
              <button onclick="remove(${full.id})" class="btn btn-danger" >Hapus</button>
            `;
          }
        },
    ]
});

promo.on("order.dt search.dt", () => {
  promo.column(0, {
        search: "applied",
        order: "applied"
    }).nodes().each((el, val) => {
        el.innerHTML = val + 1
    });
});

function remove(id) {
    Swal.fire({
        title: "Hapus",
        text: "Hapus data ini?",
        type: "warning",
        showCancelButton: true
    }).then((e) => {
      if(e.dismiss != 'cancel')
      $.ajax({
          url: "<?= base_url('promo/delete/') ?>"+id,
          type: "post",
          dataType: "json",
          success: () => {
              Swal.fire("Sukses", "Sukses Menghapus Data", "success");
              reloadTable();
          },
          error: () => {
              console.log(a);
          }
      })
    })
}

function reloadTable() {
    promo.ajax.reload()
}
// console.log(promo.rows().data())
</script>
</body>
</html>
