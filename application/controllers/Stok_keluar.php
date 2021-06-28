<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_keluar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('stok_keluar_model');
		$this->load->model('stok_masuk_model');
		$this->load->model('transaksi_model');
	}

	public function tambah()
	{
		$data['barang']=$this->stok_masuk_model->barang();
		$this->load->view('kurang_stok',$data);
	}

	public function index()
	{
		$this->load->view('stok_keluar');
	}

	public function read()
	{
		header('Content-type: application/json');
		$data[] = array();
		$query = $this->transaksi_model->query("
			select date_format(tanggal,'%d %b %Y') as tanggal,
			
			GROUP_CONCAT(DISTINCT nama_produk SEPARATOR ', ') as produk,
			sum(jumlah) as jumlah
			from stok_masuk
			join produk on produk.id = stok_masuk.barcode
			group by date_format(tanggal,'%d %b %Y')
		");
		foreach ($query as $stok_masuk) {
			$data[] = array(
				'tanggal' => $stok_masuk->tanggal,
				'produk' => $stok_masuk->produk,
				'faktur' => "FA/".strtotime($stok_masuk->tanggal)."/T".$stok_masuk->jumlah,
				'jumlah' => $stok_masuk->jumlah,
				'jenis' => "Tambah Stok Manual",
				'status' => "SELESAI",
			);
		}
		$stok_keluar = array(
			'data' => $data
		);
		echo json_encode($stok_keluar);
	}

	public function add()
	{
		$produks = json_decode($this->input->post('produk'));
		foreach ($produks as $key => $produk) {
			$tanggal = new DateTime($produk->tanggal);
			$produk->tanggal = $tanggal->format('Y-m-d H:i:s');
			$this->stok_keluar_model->create($produk);
			$this->stok_keluar_model->removeStok($produk->barcode,$produk->jumlah);
		}
		echo json_encode($this->input->post('produk'));
	}

	public function get_barcode()
	{
		$barcode = $this->input->post('barcode');
		$kategori = $this->stok_keluar_model->getKategori($id);
		if ($kategori->row()) {
			echo json_encode($kategori->row());
		}
	}

}

/* End of file Stok_keluar.php */
/* Location: ./application/controllers/Stok_keluar.php */