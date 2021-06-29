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
            <h1 class="m-0 text-dark">Detail Refund</h1>
            
            <h5><?= $transaksi->nota ?>-<?= $transaksi->tgl_refund ?></h5>
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
          <div class="col-sm-0" style="margin-right:53%; padding:7px">
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
                <h5 class="mr-0">Jenis Pengiriman : <?= $transaksi->jenis_kirim ? $transaksi->jenis_kirim : "-"?></h5>
              </div>
        </div>
        <!-- </center>
        <center> -->
        <div class="col-sm-3" style="margin:7px;">
              <div class="mb-0" style="">
                <br>
                <h5 class="mr-0">Piutang</h5>
                <h5 class="mr-0">DP/Full : <?= $transaksi->piutang_kurang == 0 ? 'Full' : 'DP' ?></h5>
                <h5 class="mr-0">Kekurangan : <?= $transaksi->piutang_kurang ?></h5>
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
            <button type="button" class="btn btn-default float-right" id="daterange-btn">
               <i class="far fa-calendar-alt"></i> Date range picker
               <i class="fas fa-caret-down"></i>
            </button>
            
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
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
</body>
</html>