<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transaksi</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') ?>">
  <?php $this->load->view('partials/head'); ?>
  <style>
    @media(max-width: 576px){
      .nota{
        justify-content: center !important;
        text-align: center !important;
      }
    }
  </style>
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
            <h1 class="m-0 text-dark">Transaksi</h1>
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
          <div class="col-sm-6 text-left nota">
            <div>
              <div class="mb-2">
                <b class="mr-2">Nota</b> <span id="nota"></span>
              </div>
            </div>
            <div class="mb-2"><select id="pelanggan" style="width: 200px;" class="form-control select2 col-sm-6" onchange="getNama()"></select></div>
            <div class="mb-2"><input id="tanggal" style="width: 200px;" type="text" class="form-control" placeholder="Tanggal" name="tanggal" required></div>
          </div>
          <div class="col-sm-6 text-right nota">
            <div>
              <div class="mb-0">
                <b class="mr-2">Total Harga</b>
              </div>
              <span id="total" style="font-size: 80px; line-height: 1" class="text-danger">0</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <div style="display: inline-block; vertical-align: bottom;">
                <b class="mr-2">Produk</b>
                <select id="barcode" style="width: 200px;" class="form-control select2 col-sm-6" onchange="getNama()"></select>
              </div>
              <div style="display: inline-block; vertical-align: bottom; width: 100px;">
                <input type="number" class="form-control" placeholder="Jumlah" id="jumlah" onkeyup="checkEmpty()">
              </div>
              <button style="display: inline-block; vertical-align: bottom;" id="tambah" class="btn btn-success" onclick="checkStok()" disabled>Tambah</button>
              <button style="display: inline-block; vertical-align: bottom;" id="bayar" class="btn btn-success" data-toggle="modal" data-target="#modal" disabled>Bayar</button>
              <div>
                <!-- <span class="text-muted" id="nama_produk"></span> -->
                <small class="text-muted" id="sisa"></small>
              </div>
            </div>
          </div>
          
        </div>
        </div>
        <div class="card-body">
          <table class="table w-100 table-bordered table-hover" id="transaksi">
            <thead>
              <tr>
                <th>Barcode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>HargaTotal</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
          <div class="row" style="margin-top: 2rem;">
            <div class="col-sm" style="height: 150px; border: 1px solid #ced4da; border-radius: .25rem; margin: 0 10px;">
              Delivery
              <select class="form-control form-control-sm" name="marketplace" place>
                <option>Marketplace</option>
                <option value="bukalapak">bukalapak</option>
                <option value="shopee">shopee</option>
                <option value="tokopediaCS1">tokopedia cs1</option>
                <option value="tokopediaCS3">tokopedia cs3</option>
              </select>
              <select class="form-control form-control-sm" name="jenis_pengiriman" place>
                <option>Jenis Pengiriman</option>
                <option value="JNE">JNE</option>
                <option value="JNT">JNT</option>
                <option value="pos indonesia">Pos Indonesia</option>
              </select>
              <input class="form-control form-control-sm" type="number" name="ongkir" placeholder="Ongkir">
            </div>
            <div class="col-sm" style="height: 150px; border: 1px solid #ced4da; border-radius: .25rem;margin: 0 10px;">
              Piutang
              <input class="form-control form-control-sm" name="dp_piutang" type="number" placeholder="Nominal">
              <input class="form-control form-control-sm" name="piutang_kurang" type="number" placeholder="Kurang">
            </div>
            
          </div>
        </div>
        
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>

<div class="modal fade" id="modal">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">Bayar</h5>
    <button class="close" data-dismiss="modal">
      <span>&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form id="form">
      <!-- <div class="form-group">
        <label>Tanggal</label>
        <input type="text" class="form-control" name="tanggal" id="tanggal" required>
      </div>
      <div class="form-group">
        <label>Pelanggan</label>
        <select name="pelannggan" id="pelanggan" class="form-control select2"></select>
      </div> -->
      <div class="form-group">
        <label>Jumlah Uang</label>
        <input placeholder="Jumlah Uang" type="number" class="form-control" name="jumlah_uang" onkeyup="kembalian()" required>
      </div>
      <div class="form-group">
        <label>Diskon</label>
        <input placeholder="Diskon" type="number" class="form-control" onkeyup="kembalian()" name="diskon">
      </div>
      <div class="form-group">
        <label>Jenis Bayar</label>
        <select name="pelannggan" id="jenis_bayar" class="form-control select2">
          <option>Bank / Transfer</option>
          <option>Cash</option>
        </select>
      </div>
      <div class="form-group">
        <label>Bank</label>
        <select name="pelannggan" id="opsi_bank" class="form-control select2">
          <option>BCA</option>
          <option>BRI</option>
        </select>
      </div>
      <div class="form-group">
        <b>Total Bayar:</b> <span class="total_bayar"></span>
      </div>
      <div class="form-group">
        <b>Kembalian:</b> <span class="kembalian"></span>
      </div>
      <button id="add" class="btn btn-success" type="submit" onclick="bayar()" disabled>Bayar</button>
      <button id="cetak" class="btn btn-success" type="submit" onclick="bayarCetak()" disabled>Bayar Dan Cetak</button>
      <button class="btn btn-danger" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>
</div>
</div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/select2/js/select2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/moment/moment.min.js') ?>"></script>
<script>
  var produkGetNamaUrl = '<?php echo site_url('produk/get_nama') ?>';
  var produkGetStokUrl = '<?php echo site_url('produk/get_stok') ?>';
  var addUrl = '<?php echo site_url('transaksi/add') ?>';
  var getBarcodeUrl = '<?php echo site_url('produk/get_barcode') ?>';
  var pelangganSearchUrl = '<?php echo site_url('pelanggan/search') ?>';
  var cetakUrl = '<?php echo site_url('transaksi/cetak/') ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/transaksi.js') ?>"></script>
</body>
</html>
