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
          <div class="col">
            <h1 class="m-0 text-dark">Detail Penjualan</h1>
          </div><!-- /.col -->
          <div class="col">
            <div style="float:right">
               <button class="btn btn-success" onclick="refund()">Refund</button> 
              <a href="<?php echo base_url('transaksi/cetak/'.$id); ?>"> <button class="btn btn-success">Cetak</button> </a>
            </div>
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
        <div class="row">
          <div class="col-sm-0" style="margin-right:55%; padding:7px">
              <div class="mb-0">
              <h5>Nota <span id="nota"><?= $transaksi->nota ?></span></h5>
                
              </div>
              <br>
            </div>
            
            <div class="col-sm-0" style="padding:7px">
            <div>
              <div class="mb-0">
                <h6 class="mr-0">Tanggal  : <?= $transaksi->tanggal ?></h6>
                <h6 class="mr-5">Pelanggan  : <?= $transaksi->nama_pelanggan ?></h6>
              </div>
            </div>
        </div>
          </div>
          <!-- <div class="col-sm-6 text-center nota">
            <div>
              <div class="mb-0" style="">
                <b class="mr-0">Tanggal  :</b>
                <br>
                <b class="mr-0">Pelanggan  :</b>
              </div>
            </div>
          </div> -->
        <!-- <center> -->
        
      <div class="row">
      <div class="col-sm-2">
        </div>
        <div class="col-sm-3" style="margin:7px;">
              <div class="mb-0">
                <br>
                <h5 class="mr-0">Delivery</h5>
                <h5 class="mr-0">Marketplace : <?= $transaksi->nama_marketplace ? $transaksi->nama_marketplace : "-" ?></h5>
                <h5 class="mr-0">Jenis Pengiriman : <?= $transaksi->jenis_kirim ? $transaksi->jenis_kirim : "-"  ?></h5>
              </div>
        </div>
        <!-- </center>
        <center> -->
        <div class="col-sm-3" style="margin:7px;">
              <div class="mb-0" style="">
                <br>
                <h5 class="mr-0">Piutang</h5>
                <h5 class="mr-0">DP/Full : <?= $transaksi->jenis_piutang ? $transaksi->jenis_piutang : "-" ?></h5>
                <h5 class="mr-0">Kekurangan : <?= $transaksi->piutang_kurang ? $transaksi->piutang_kurang : "-"?></h5>
              </div>
        </div>
        <div class="col-sm-3" style="margin:7px;">
              <div class="mb-0" style="">
                <br>
                <h5 class="mr-0">Diskon : <?= $transaksi->diskon ?></h5>
                <h5 class="mr-0">Bayar : <?= $transaksi->jumlah_uang ?></h5>
                <h5 class="mr-0">Kembali : <?= $transaksi->jumlah_uang - ($transaksi->total_bayar - $transaksi->diskon - $transaksi->piutang_kurang) ?></h5>
                <h5 class="mr-0">Jenis Bayar : <?= $transaksi->jenis_bayar ? $transaksi->jenis_bayar : "-" ?></h5>
              </div>
              <!-- <?php print_r($transaksi) ?> -->
              <br>
              <br>
          <div class="col-sm-0">
              <div class="mb-0">
                <h4 class="mr-0">Total Harga</h4>
              </div>
              <span id="total" style="font-size: 46px; line-height: 1" class="text-danger"><?= $transaksi->total_bayar ?></span>
            </div>
            </div>
          </div>   
        </div>
        
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="detail_transaksi">
              <thead>
              <tr>
                  <th>No</th>
                  <th>Barcode</th> 
                  <th>Nama Produk</th> 
                  <th>Jumlah</th> 
                  <th>Harga</th> 
                  <th>Subtotal</th> 
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
<script>
  var readUrl = '<?php echo site_url('transaksi/getdetail/'.$id) ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/detail_transaksi.js') ?>"></script>
<script>
  
    function refund() {
      $.ajax({
          url: '<?php echo base_url('laporan/refunded/'.$id); ?>',
          type: "get",
          success: res => {
            console.log(res)
            Swal.fire("Sukses", "Sukses Refund", "success")
            .then(() => window.location.href = `<?php echo base_url('laporan/refund/'.$id); ?>`)
          },
          error: err => {
              console.log(err)
          }
      })
    }
</script>
</body>
</html>