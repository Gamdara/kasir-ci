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
			$data["total_penjualan"] = $this->transaksi_model->query("select sum(total_bayar) as total_bayar from transaksi")[0]->total_bayar;
			$data["total_transaksi"] = $this->transaksi_model->query("select count(id) as total_transaksi from transaksi")[0]->total_transaksi;
			$data["total_pengeluaran"] = $this->transaksi_model->query("select sum(nominal) as total_pengeluaran from pengeluaran")[0]->total_pengeluaran;
			
			$data["produk"] = $this->transaksi_model->query("select * from produk");
			$data["pengeluaran"] = $this->transaksi_model->query("select * from pengeluaran");
			
			$this->load->view('dashboard', $data);
		} else {
			$this->load->view('login');
		}
	}
}
