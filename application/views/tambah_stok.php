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
            <h1 class="m-0 text-dark">Tambah Stok Masuk</h1>
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
          <div class="col-sm-6">
          <div class="form-group">
              <label>Tanggal</label>
              <input id="tanggal" type="text" class="form-control col-sm-6" 
              value="<?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s');?> " name="tanggal" disabled>
          </div>
          <div class="form-group">
              <label>Supplier</label>
              <select class="form-control" name="supplier" id="supplier">
              <option value="">No Selected</option>
              <?php foreach($supplier as $k) : ?>
                            <option value="<?php echo $k->id_supplier,$k->nama;?>" > <?php echo $k->nama; ?></option>
              <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Nama Barang</label>
              <div class="form-inline">
              <select class="form-control select2" style="width: 100%;" name="barang" id="barang">
              <option value="">No Selected</option>
              <?php foreach($barang as $k) : ?>
                            <option value="<?php echo $k->id_produk;?>" > <?php echo $k->nama_produk; ?></option>
              <?php endforeach; ?>
              </select>
              </select>
              </select>
              </div>
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" class="form-control col-sm-6" placeholder="Jumlah" name="jumlah" id="jumlah">
            </div>
            <div class="form-group">
              <button id="tambah" class="btn btn-success" onclick="tambah();">Tambah</button>
            </div>
          </div>
          <div class="col-sm-6 d-flex justify-content-end text-right nota">
            <div>
              <div class="mb-0">
                <b class="mr-2">Nota</b> <span id="nota"><?php echo 'STM-'.date('dmyHis', time());?></span>
              </div>
              <span id="total" style="font-size: 80px; line-height: 1" class="text-danger">0</span>
            </div>
          </div>
        </div>
        </div>
        <div class="card-body">
        <b class="mr-2">Tanggal : </b> <span id="nota"></span>
          <table class="table w-100 table-bordered table-hover">
            <thead>
              <tr>
                <th>Supplier</th>
                <th>Nama Barang</th>
                <!--<th>Harga Beli</th>-->
                <th>Stok Ditambahkan</th>
                <!--<th>Total</th>-->
                <th>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="card-body">
              <button id="bayar" class="btn btn-success" data-toggle="modal" data-target="#modal" disabled>Simpan</button>
            </div>
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
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/select2/js/select2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/moment/moment.min.js') ?>"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
<script>
      function getNama() {
        $.ajax({
            type: "post",
            dataType: "json",
            data: {
                id: $("#id_produk").val()
            },
            success: res => {
                $("#nama_produk").html(res.nama_produk);
                $("#harga_beli").html(res.harga_beli);
            },
            error: err => {
                console.log(err)
            }
        })
    }
    function tambah()
            {
                
                // untuk ambil nilai pada input
                 var sup = document.getElementById('supplier').value;
                 var barang = document.getElementById('barang').value;
                 var jumlah = document.getElementById('jumlah').value;
                  
                  
                  // 0 = baris awal pada tabel
                  var table = document.getElementsByTagName('table')[0];
                  
                  // tambah baris kosong pada tabel
                  // 0 = dihitung dari atas 
                  // table.rows.length = menambahkan pada akhir baris
                  // table.rows.length/2 = menambahkan data pada baris tengah tabel , urutan baris ke 2 
                  var newRow = table.insertRow(table.rows.length);
                  
                  // tambah cell pada baris baru
                  var cell1 = newRow.insertCell(0);
                  var cell2 = newRow.insertCell(1);
                  var cell3 = newRow.insertCell(2);
                  var cell4 = newRow.insertCell(3);
                  
                  // tambah nilai ke dalam cell
                  cell1.innerHTML = sup;
                  cell2.innerHTML = barang;
                  cell3.innerHTML = jumlah;
                  cell4.innerHTML = '<button id="tambah" class="btn btn-success">Delete</button>';
            }
</script>
</body>
</html>
