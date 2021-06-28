<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
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
            <h1 class="m-0 text-dark">Dashboard Mastha</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="transaksi_hari"><?= $total_penjualan ?></h3>
                <p>Total Penjualan Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="<?php echo site_url('detail') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="transaksi_terakhir"><?= $total_transaksi ?></h3>
                <p>Total Transaksi Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill"></i>
              </div>
              <a href="<?php echo site_url('detail') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="stok_hari"><?= $total_pengeluaran ?></h3>
                <p>Total Pengeluaran Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-archive"></i>
              </div>
              <a href="<?php echo site_url('laporan/pengeluaran') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- <div class="col-12">
            <h1 class="mt-2 mb-3 h2 text-dark">Grafik</h1>
          </div> -->
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Produk Terjual Hari Ini</h3>
              </div>
              <div class="card-body">
                <?php foreach ($produk_harian as $p) { ?>
                  <li class="list-group-item">
                    <?= $p->nama_produk ?>
                    <span class="float-right"><?= $p->jumlah ?></span>
                  </li>
                <?php } ?>
                <!-- <div class="chart">
                  <canvas id="produkTerlaris" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%"></canvas>
                </div> -->
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Pengeluaran Hari Ini</h3>
              </div>
              <div class="card-body">
                <?php foreach ($pengeluaran_harian as $p) { ?>
                  <li class="list-group-item">
                    <?= $p->keterangan ?>
                    <span class="float-right"><?= $p->nominal ?></span>
                  </li>
                <?php } ?>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Produk Terjual </h3>
              </div>
              <div class="card-body">
                <?php foreach ($produk as $p) { ?>
                  <li class="list-group-item">
                    <?= $p->nama_produk ?>
                    <span class="float-right"><?= $p->terjual ?></span>
                  </li>
                <?php } ?>
                <!-- <div class="chart">
                  <canvas id="produkTerlaris" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%"></canvas>
                </div> -->
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Pengeluaran</h3>
              </div>
              <div class="card-body">
                <?php foreach ($pengeluaran as $p) { ?>
                  <li class="list-group-item">
                    <?= $p->keterangan ?>
                    <span class="float-right"><?= $p->nominal ?></span>
                  </li>
                <?php } ?>
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
<!-- ./wrapper -->

<?php $this->load->view('includes/footer'); ?>

<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
  var transaksi_hariUrl = '<?php echo site_url('transaksi/transaksi_hari') ?>';
  var transaksi_terakhirUrl = '<?php echo site_url('transaksi/transaksi_terakhir') ?>';
  var stok_hariUrl = '<?php echo site_url('stok_masuk/stok_hari') ?>';
  var produk_terlarisUrl = '<?php echo site_url('produk/produk_terlaris') ?>';
  var data_stokUrl = '<?php echo site_url('produk/data_stok') ?>';
  var penjualan_bulanUrl = '<?php echo site_url('transaksi/penjualan_bulan') ?>';
</script>
<!-- <script src="<?php echo base_url('assets/js/unminify/dashboard.js') ?>"></script> -->
</body>
</html>
