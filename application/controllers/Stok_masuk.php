<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_masuk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('stok_masuk_model');
	}

	public function index()
	{
		$this->load->view('stok_masuk');
	}

	public function list_stok()
	{
		$this->load->view('daftar_stok');
	}
	
	public function tambah()
	{
		$data['supplier']=$this->stok_masuk_model->supplier();
		$data['barang']=$this->stok_masuk_model->barang();
		$this->load->view('tambah_stok',$data);
	}

	function supplier($sup){
		$b['sup']=$this->stok_masuk_model->get_supplier($sup)->nama;
		$this->load->view('tambah_stok',$b);
	}
	public function read()
	{
		header('Content-type: application/json');
		if ($this->stok_masuk_model->read()->num_rows() > 0) {
			foreach ($this->stok_masuk_model->read()->result() as $stok_masuk) {
				$tanggal = new DateTime($stok_masuk->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'barcode' => $stok_masuk->barcode,
					'nama_produk' => $stok_masuk->nama_produk,
					'jumlah' => $stok_masuk->jumlah,
					'bayar' => $stok_masuk->bayar
				);
			}
		} else {
			$data = array();
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	public function add()
	{
		$produks = json_decode($this->input->post('produk'));
		foreach ($produks as $key => $produk) {
			$tanggal = new DateTime($produk->tanggal);
			$produk->tanggal = $tanggal->format('Y-m-d H:i:s');
			$this->stok_masuk_model->create($produk);
		}
		echo json_encode($this->input->post('produk'));
	}

	public function get_barcode()
	{
		$barcode = $this->input->post('barcode');
		$kategori = $this->stok_masuk_model->getKategori($id);
		if ($kategori->row()) {
			echo json_encode($kategori->row());
		}
	}

	public function laporan()
	{
		header('Content-type: application/json');
		if ($this->stok_masuk_model->laporan()->num_rows() > 0) {
			foreach ($this->stok_masuk_model->laporan()->result() as $stok_masuk) {
				$tanggal = new DateTime($stok_masuk->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'barcode' => $stok_masuk->barcode,
					'nama_produk' => $stok_masuk->nama_produk,
					'jumlah' => $stok_masuk->jumlah,
					'keterangan' => $stok_masuk->keterangan,
					'supplier' => $stok_masuk->supplier
				);
			}
		} else {
			$data = array();
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	public function stok_hari()
	{
		header('Content-type: application/json');
		$now = date('d m Y');
		$total = $this->stok_masuk_model->stokHari($now);
		echo json_encode($total->total == null ? 0 : $total);
	}

}

/* End of file Stok_masuk.php */
/* Location: ./application/controllers/Stok_masuk.php */
