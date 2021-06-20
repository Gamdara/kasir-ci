<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo site_url('') ?>" class="brand-link text-center">
    <span class="brand-text font-weight-light"><?php echo $this->session->userdata('master.toko')->nama ?></span>
  </a>
  <?php $uri = $this->uri->segment(1) ?>
  <?php $role = $this->session->userdata('role'); ?>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php echo site_url('dashboard') ?>" class="nav-link <?php echo $uri == 'dashboard' || $uri == '' ? 'active' : 'no' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="<?php echo site_url('produk') ?>" class="nav-link <?php echo $uri == 'produk' ? 'active' : 'no' ?>">
          <i class="nav-icon fas fa-truck"></i>
            <p>
              Master
            </p>
            <i class="right fas fa-angle-right"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url('gudang') ?>" class="nav-link <?php echo $uri == 'gudang' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Gudang
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('karyawan') ?>" class="nav-link <?php echo $uri == 'karyawan' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Karyawan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('platform') ?>" class="nav-link <?php echo $uri == 'platform' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Platform
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('reseller') ?>" class="nav-link <?php echo $uri == 'reseller' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Reseller
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('supplier') ?>" class="nav-link <?php echo $uri == 'supplier' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Supplier
                </p>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo site_url('transaksi') ?>" class="nav-link <?php echo $uri == 'transaksi' ? 'active' : 'no' ?>">
            <i class="fas fa-money-bill nav-icon"></i>
            <p>Transaksi</p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="<?php echo site_url('produk') ?>" class="nav-link <?php echo $uri == 'produk' ? 'active' : 'no' ?>">
            <i class="nav-icon fas fa-box"></i>
            <p>
              Produk
            </p>
            <i class="right fas fa-angle-right"></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url('kategori_produk') ?>" class="nav-link <?php echo $uri == 'kategori_produk' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Kategori Produk
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('produk') ?>" class="nav-link <?php echo $uri == 'produk' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Daftar Produk
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview <?php echo $uri == 'stok_masuk' || $uri == 'stok_keluar' ? 'menu-open' : 'no' ?>">
          <a href="#" class="nav-link <?php echo $uri == 'stok_masuk' || $uri == 'stok_keluar' ? 'active' : 'no' ?>">
            <i class="fas fa-archive nav-icon"></i>
            <p>Inventory</p>
            <i class="right fas fa-angle-right"></i>
          </a>
          <ul class="nav-treeview">
            <li class="nav-item">
              <a href="<?php echo site_url('stok_masuk') ?>" class="nav-link <?php echo $uri == 'stok_masuk' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Stok Masuk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('stok_masuk/list_stok') ?>" class="nav-link <?php echo $uri == 'stok_masuk/list_stok' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Daftar Stok</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('stok_keluar') ?>" class="nav-link <?php echo $uri == 'stok_keluar' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Stok Keluar</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview <?php echo $uri == 'laporan_penjualan' || $uri == 'laporan_stok_masuk' || $uri == 'laporan_stok_keluar' ? 'menu-open' : 'no' ?>">
          <a href="<?php echo site_url('laporan') ?>" class="nav-link <?php echo $uri == 'laporan_penjualan' || $uri == 'laporan_stok_masuk' || $uri == 'laporan_stok_keluar' ? 'active' : 'no' ?>">
            <i class="fas fa-book nav-icon"></i>
            <p>Laporan</p>
            <i class="right fas fa-angle-right"></i>
          </a>
          <ul class="nav-treeview">
          <li class="nav-item">
              <a href="<?php echo site_url('detail') ?>" class="nav-link <?php echo $uri == 'detail' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Detail Penjualan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_penjualan') ?>" class="nav-link <?php echo $uri == 'laporan_penjualan' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Harian</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_penjualan/bulanan') ?>" class="nav-link <?php echo $uri == 'laporan_penjualan/bulanan' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Bulanan </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_refund') ?>" class="nav-link <?php echo $uri == 'laporan_refund' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan refund </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_stok_keluar') ?>" class="nav-link <?php echo $uri == 'laporan_stok_keluar' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Piutang </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo site_url('laporan_penjualan/laporan_pengeluaran') ?>" class="nav-link <?php echo $uri == 'laporan_penjualan/laporan_pengeluaran' ? 'active' : 'no' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Pengluaran </p>
              </a>
            </li>
          </ul>
        </li>
        <?php if ($role === 'admin'): ?>
          <li class="nav-item">
            <a href="<?php echo site_url('pengaturan') ?>" class="nav-link <?php echo $uri == 'pengaturan' ? 'active' : 'no' ?>">
              <i class="fas fa-cog nav-icon"></i>
              <p>Pengaturan</p>
            </a>
          </li>
        <?php endif ?>
       
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>