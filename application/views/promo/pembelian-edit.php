

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Produk</title>
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
            <h1 class="m-0 text-dark">Edit Promo</h1>
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
          <div class="col-sm-6 p-3">
          <form action="<?php echo base_url('promo/editbeli/'.$id) ?>" method="post">
            <div class="form-group">
              <label>Status</label>
              <select class="form-control" name="status" id="kategori">
                <option value="aktif" <?= $jenis == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="nonaktif" <?= $jenis == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
              </select>
            </div>
            <div class="form-group">
              <label> Nama Promo</label>
              <input type="text" class="form-control col-sm-6" placeholder="Nama" id="nama" name="nama" value="<?= $nama ?>">
              <?= form_error('nama', '<small class="pl-3 text-danger">', '</small>'); ?>
            </div>
            <div class="form-group">
              <label> Deskripsi</label>
              <textarea name="deskripsi" class="form-control col-sm-6" id="" cols="30" rows="10" ><?= $deskripsi ?></textarea>
              <?= form_error('deskripsi', '<small class="pl-3 text-danger">', '</small>'); ?>
            </div>
            <div class="form-group date">
              <label> Durasi Hingga</label>
              <input type="text" class="form-control col-sm-6 " placeholder="Durasi" id="durasi" name="durasi" value="<?= $durasi ?>" readonly>
              <span class="input-group-addon">
               <span class="glyphicon glyphicon-calendar"></span>
              <?= form_error('durasi', '<small class="pl-3 text-danger">', '</small>'); ?>
            </div>

            <!-- <li class="nav-item has-treeview">
              <p>Jenis Bonus</p>
              <i class="right fas fa-angle-right"></i>
              <ul class="nav nav-treeview">
                <li class="nav-item"> -->
                  <div class="form-group">
                    <label>Jenis Potongan</label>
                    <select class="form-control" name="jenis" id="kategori">
                        <option value="persen" <?= $jenis == 'persen' ? 'selected' : '' ?>>Potongan (%)</option>
                        <option value="rp" <?= $jenis == 'rp' ? 'selected' : '' ?>>Potongan (rp)</option>
                      </select>
                    <?= form_error('jenis', '<small class="pl-3 text-danger">', '</small>'); ?>
                  </div>
                <!-- </li>
                <li class="nav-item"> -->
                  <div class="form-group">
                    <label>Nilai Potongan</label>
                    <input type="number" name="potongan" id="" value="<?= $potongan ?>" class="form-control col-sm-6" placeholder="Nilai Potongan" id="potongan">
                    <?= form_error('potongan', '<small class="pl-3 text-danger">', '</small>'); ?>
                  </div>
                <!-- </li>
              </ul>
            </li> -->

            <div class="form-group">
              <label> Minimal Pembelian </label>
              <input type="text" class="form-control col-sm-6" value="<?= $min_beli?>" placeholder="Minimal Pembelian" id="min_beli" name="min_beli">
              <?= form_error('min_beli', '<small class="pl-3 text-danger">', '</small>'); ?>
            </div>
             <div class="form-group">
              <button class="btn btn-success" type="submit">Update</button>
            </div>
            </form>
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
</body>
</html>

<script>
  $( function() {
    $( "#durasi" ).datetimepicker({
      pickTime: false,
        minView: 2,
        format: 'yyyy-mm-dd',
        autoclose: true
    });
  } );

</script>