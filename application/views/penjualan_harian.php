<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Penjualan</title>
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
        <div class="col d-flex flex-row justify-content-between">
            <h1 class="m-0 text-dark">Laporan Penjualan Harian</h1>
            <select class="form-control col-sm-4"  id="kategori">
              <option value="hari">Harian</option>
              <option value="bulan">Bulanan</option>
            </select>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="container">
        <canvas height="100px" id="canvas"></canvas>
      </div>
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="laporan_penjualan">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Harga Beli</th> 
                  <th>Harga Jual</th> 
                  <th>Jumlah Transaksi</th> 
                  <th>Pengeluaran</th> 
                  <th>Laba Kotor</th>
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
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
  var readUrl = '<?php echo site_url('transaksi/gethari') ?>';
  var deleteUrl = '<?php echo site_url('transaksi/delete') ?>';
  let labels = [];
  let datas = [];
</script>
<script src="<?php echo base_url('assets/js/unminify/laporan_penjualan.js') ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script>
  $('#kategori').change(function() {
    if ($('#kategori').val() != 'hari')
    window.location.href = '<?= base_url('laporan_penjualan/index/bulan') ?>'
  })

  $.ajax({
        url: '<?= base_url('transaksi/gethari')?>',
        type: "get",
        dataType: "json",
        success: res => {
          data = res.data
          console.log(data)
          let ctx = document.getElementById('canvas').getContext('2d');
          let chart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: data.map(r => {return r.tanggal} ),
                  datasets: [
                      {
                      label:'Pemasukan',
                      backgroundColor : "#3e95cd",
                      borderColor: ['#3e95cd'],
                      fill: false,
                      data: data.map(r => {return r.total_jual })
                      },
                      {
                      label:'Jumlah Transaksi',
                      backgroundColor : "#e25070",
                      borderColor: ['#e25070'],
                      fill: false,
                      data: data.map(r =>  {return r.jumlah_transaksi})
                      },
                          
                  ]
              },
          });
        },
        error: e => {
            console.log("diskon gamau",e)
        }
        
    })
</script>
</body>
</html>