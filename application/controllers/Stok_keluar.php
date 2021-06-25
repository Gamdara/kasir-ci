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
		if ($this->stok_keluar_model->read()->num_rows() > 0) {
			foreach ($this->stok_keluar_model->read()->result() as $stok_keluar) {
				$tanggal = new DateTime($stok_keluar->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'barcode' => $stok_keluar->barcode,
					'nama_produk' => $stok_keluar->nama_produk,
					'jumlah' => $stok_keluar->jumlah,
					'keterangan' => $stok_keluar->keterangan,
				);
			}
		} else {
			$data = array();
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