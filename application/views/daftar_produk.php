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
          <a href="<?= base_url('produk/add/'); ?>"><button class="btn btn-success">Add</button></a>
          </div>
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="produk">
              <thead>
              <tr>
                  <th>No</th>
                  <th>Kategori</th>
                  <th>Nama Produk</th>
                  <th>Harga beli</th>
                  <th>Harga jual</th>
                  <th>Harga reseller</th>
                  <th>Aksi</th>
              </tr>
              </thead>
              <!-- <tbody>
                   <?php $no = 1; 
                   foreach ($produk as $m) { ?>
                    <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $m['kategori']; ?></td>
                    <td><?= $m['nama_produk']; ?></td>
                    <td><?= $m['harga_beli']; ?></td>
                    <td><?= $m['harga_jual']; ?></td>
                    <td><?= $m['harga_reseller']; ?></td>
                    <td class="text-center"><a href="<?= base_url('produk/edit/'); ?><?= $m['id']; ?>"><button type="submit"  class="btn btn-sm btn-primary" name="edit">Edit</button></a>
                    <a href="<?= base_url('produk/delete/'); ?><?= $m['id']; ?>"><button type="submit"  class="btn btn-sm btn-primary" name="hapus">Hapus</button></a></td>
                    </tr>
                    <?php } ?>
                </tbody> -->
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
  const readUrl = '<?= base_url('produk/read') ?>'
</script>
<script src="<?php echo base_url('assets/js/unminify/produk.js') ?>"></script>
</body>
</html>
