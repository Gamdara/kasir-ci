<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('transaksi_model');
	}

	public function index()
	{
		if ($this->session->userdata('status') == 'login' ) {
			$transaksi = $this->transaksi_model->query("select ifnull(sum(total_bayar-piutang_kurang),0) as total_bayar, ifnull(count(id),0) as total_transaksi from transaksi where CAST(tanggal AS DATE) = curdate() and jenis_piutang != 'refund'")[0];
			$detail = $this->transaksi_model->query("select produk.nama_produk as nama_produk, sum(detail_transaksi.jumlah) as jumlah from detail_transaksi 
			join transaksi on detail_transaksi.id_transaksi = transaksi.id
			join produk on detail_transaksi.id_produk = produk.id
			where CAST(transaksi.tanggal AS DATE) = curdate() and transaksi.jenis_piutang != 'refund'
			group by CAST(transaksi.tanggal AS DATE), produk.nama_produk
			");
			$pengeluaran = $this->transaksi_model->query("select ifnull(sum(nominal),0) as total_pengeluaran from pengeluaran where tanggal = curdate()")[0];
			
			$pemasukan = $this->transaksi_model->query("select ifnull(sum(total_bayar - piutang_kurang),0) as kas from transaksi where jenis_piutang = 'dp' or jenis_piutang='lunas'")[0]->kas;
			$keluar = $this->transaksi_model->query("select ifnull(sum(nominal),0) as total_pengeluaran from pengeluaran")[0]->total_pengeluaran;
			$refund = $this->transaksi_model->query("select ifnull(sum(total_bayar - piutang_kurang),0) as kas from transaksi where jenis_piutang = 'refund'")[0]->kas;
			

			$data["total_penjualan"] = "Rp " . number_format($transaksi->total_bayar,2,',','.'); 
			$data["total_transaksi"] = $transaksi->total_transaksi;
			$data["total_pengeluaran"] = "Rp " . number_format( $pengeluaran->total_pengeluaran,2,',','.'); 
			$data["kas"] = "Rp " . number_format( $pemasukan-$keluar,2,',','.'); 
			

			$data["produk"] = $this->transaksi_model->query("select * from produk order by terjual desc limit 3");
			$data["pengeluaran"] = $this->transaksi_model->query("select * from pengeluaran");
			$data["produk_harian"] = $detail;
			$data["pengeluaran_harian"] = $this->transaksi_model->query("select * from pengeluaran where tanggal = curdate()");
			
			
			$this->load->view('dashboard', $data);
		} else {
			$this->load->view('login');
		}
	}
}
