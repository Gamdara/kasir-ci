<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_penjualan extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->view('penjualan_harian');
	}

	public function bulanan()
	{
		$this->load->view('penjualan_bulanan');
	}

	public function laporan_pengeluaran()
	{
		$this->load->view('laporan_pengeluaran');
	}

}

/* End of file Laporan_penjualan.php */
/* Location: ./application/controllers/Laporan_penjualan.php */