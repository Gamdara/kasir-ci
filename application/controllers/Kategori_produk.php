<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_produk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('kategori_produk_model');
	}

	public function index()
	{
		$data['kategori'] = $this->kategori_produk_model->read();
        $this->load->view('kategori_produk', $data);
	}

	/*public function read()
	{
		header('Content-type: application/json');
		if ($this->kategori_produk_model->read()->num_rows() > 0) {
			foreach ($this->kategori_produk_model->read()->result() as $kategori_produk) {
				$data[] = array(
					'kategori' => $kategori_produk->kategori,
					'action' => '<button class="btn btn-sm btn-danger" onclick="remove('.$kategori_produk->id_kategori.')">Delete</button>'
				);
			}
		} else {
			$data = array();
		}
		$kategori_produk = array(
			'data' => $data
		);
		echo json_encode($kategori_produk);
	}*/

	public function add()
	{
		$data = array(
			'kategori' => $this->input->post('kategori')
		);
		if ($this->kategori_produk_model->create($data)) {
			echo json_encode('sukses');
		}
	}

	/*`public function delete()
	{
		$id_kategori = $this->input->post('id_kategori');
		if ($this->kategori_produk_model->delete($id_kategori)) {
			echo json_encode('sukses');
		}
	}*/

	public function delete($id_kategori)
	{
		$this->kategori_produk_model->delete($id_kategori);
		echo '<script>
                alert("Sukses Menghapus Data ");
                window.location="'.base_url('kategori_produk').'"
            </script>';
	}

	public function get_kategori()
	{
		$id = $this->input->post('id');
		$kategori = $this->kategori_produk_model->getKategori($id);
		if ($kategori->row()) {
			echo json_encode($kategori->row());
		}
	}

	public function search()
	{
		header('Content-type: application/json');
		$kategori = $this->input->post('kategori');
		$search = $this->kategori_produk_model->search($kategori);
		foreach ($search as $kategori) {
			$data[] = array(
				'id' => $kategori->id,
				'text' => $kategori->kategori
			);
		}
		echo json_encode($data);
	}

}

/* End of file Kategori_produk.php */
/* Location: ./application/controllers/Kategori_produk.php */