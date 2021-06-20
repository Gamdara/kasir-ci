<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('produk_model');
	}

	public function index()
	{
		$data['produk']=$this->produk_model->view();
		$this->load->view('daftar_produk',$data);
	}



	public function add()
	{
		$validation = $this->form_validation; //untuk menghemat penulisan kode

        $validation->set_rules('nama', 'Nama', 'required');
        $validation->set_rules('kategori', 'Kategori', 'required');
        $validation->set_rules('beli', 'Harga Beli', 'required');
        $validation->set_rules('jual', 'Harga Jual', 'required');
		$validation->set_rules('resell', 'Harga Reseller', 'required');

        if($validation->run() == FALSE) //jika form validation gagal tampilkan kembali form tambahnya
        {
			$data['kategori_produk']=$this->produk_model->get_kategori();
            $this->load->view('tambah_produk',$data);
        } else {
		  $this->produk_model->tambah();
          redirect('produk');
        }
	}

	/*public function delete()
	{
		$id = $this->input->post('id');
		if ($this->produk_model->delete($id)) {
			echo json_encode('sukses');
		}
	}*/

	function edit($id_produk){
		$where = array('id_produk' => $id_produk);
		$data['kategori_produk']=$this->produk_model->get_kategori();
		$data['produk'] = $this->produk_model->edit_data($where,'master.produk')->result();
		$this->load->view('edit_produk',$data);
		}
	
	function update(){
		$id_produk = $this->input->post('id_produk');
		$nama_produk = $this->input->post('nama');
		$id_kategori = $this->input->post('kategori');
		$harga_beli = $this->input->post('beli');
		$harga_jual = $this->input->post('jual');
		$harga_reseller = $this->input->post('resell');

	
			$data = array(
				'nama_produk' => $nama_produk,
				'id_kategori' => $id_kategori,
				'harga_beli' => $harga_beli,
				'harga_jual' => $harga_jual,
				'harga_reseller'=>$harga_reseller
			);
		 
			$where = array(
				'id_produk' => $id_produk
			);
			
			$this->produk_model->update_data($where,$data,'master.produk');
			redirect('produk');
		}

	public function get_produk()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		$kategori = $this->produk_model->getProduk($id);
		if ($kategori->row()) {
			echo json_encode($kategori->row());
		}
	}

	public function get_barcode()
	{
		header('Content-type: application/json');
		$barcode = $this->input->post('barcode');
		$search = $this->produk_model->getBarcode($barcode);
		foreach ($search as $barcode) {
			$data[] = array(
				'id' => $barcode->id,
				// 'text' => $barcode->barcode,
				'text' => $barcode->nama_produk
			);
		}
		echo json_encode($data);
	}

	public function get_nama()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		echo json_encode($this->produk_model->getNama($id));
	}

	public function get_stok()
	{
		header('Content-type: application/json');
		$id = $this->input->post('id');
		echo json_encode($this->produk_model->getStok($id));
	}

	public function produk_terlaris()
	{
		header('Content-type: application/json');
		$produk = $this->produk_model->produkTerlaris();
		foreach ($produk as $key) {
			$label[] = $key->nama_produk;
			$data[] = $key->terjual;
		}
		$result = array(
			'label' => $label,
			'data' => $data,
		);
		echo json_encode($result);
	}

	public function data_stok()
	{
		header('Content-type: application/json');
		$produk = $this->produk_model->dataStok();
		echo json_encode($produk);
	}

}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */