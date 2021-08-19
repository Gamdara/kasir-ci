<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('promo_model');
		$this->load->model('produk_model');
	}

	public function index()
	{
		$data['produk']=$this->promo_model->view();
		$this->load->view('daftar_produk',$data);
	}

	public function pembelian()
	{
		$this->load->view('promo/pembelian-table');
	}

	public function produk()
	{
		$this->load->view('promo/produk-table');
	}

	public function read($ctg){
		$data= array(
			'data' => $this->promo_model->getWhere(array('promo.kategori' => $ctg))
		);
		echo json_encode($data);
	}

	public function addPembelian()
	{
		$this->load->view('promo/pembelian-add');
	}

	public function addProduk()
	{
		$this->load->view('promo/produk-add');
	}

	public function test(){
		var_dump(!$this->promo_model->getDetail(array('id_promo' => '12', 'id_produk' => '2')));
	}

	public function editproduk($id){
		if($this->input->post()) {
			$this->promo_model->deleteDetail(array('id_promo' => $id));
			$data = $this->input->post();
			$produks = json_decode($data["produk"]);
			unset($data['produk']);
			foreach ($produks as $produk) {
				$where = array(
					'id_produk' => $produk->id,
					'id_promo' => $id,
					'min_jumlah' => $produk->min_jumlah
				);
				$this->promo_model->insertDetail($where);	
			}
			$this->promo_model->update($data, $id);
			redirect('promo/produk');	
		}
		$data = $this->promo_model->getWhere(array('promo.id' => $id));
		$data[0]['produks'] = json_encode($this->promo_model->getDetail(array('id_promo' => $id)));
		$this->load->view('promo/produk-edit', $data[0]);
	}

	public function editbeli($id){
		if($this->input->post()) {
			$this->promo_model->update($this->input->post(), $id);
			redirect('promo/pembelian');	
		}
		$data = $this->promo_model->getWhere(array('promo.id' => $id));
		$this->load->view('promo/pembelian-edit', $data[0]);
	}

	public function getDiskon(){
		$data = $this->input->post();
		$diskon = $this->promo_model->getPromo($data['total'], $data['produk']);
		echo json_encode($diskon);
	}

	public function add(){
		$validation = $this->form_validation;

        $validation->set_rules('nama', 'Nama', 'required');
        $validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $validation->set_rules('potongan', 'Potongan', 'required');
        $validation->set_rules('jenis', 'Jenis', 'required');
		$validation->set_rules('durasi', 'Durasi', 'required');
		$validation->set_rules('min_beli', 'Minimal Pembelian', 'required');

        if($validation->run() == FALSE) 
            redirect($_SERVER['HTTP_REFERER']);
		
		$data = $this->input->post();
		$data['status'] = 'aktif';
		if(isset($data['produk'])){
			$produks = json_decode($data["produk"]);
			unset($data['produk']);
		}
		$this->promo_model->insert($data);
		$id = $this->db->insert_id();
		if(isset($produks)){
			foreach ($produks as $p) {
				$data = array(
					'id_produk' => $p->id,
					'id_promo' => $id,
					'min_jumlah' => $p->min_jumlah
				);
				$this->promo_model->insertDetail($data);
			}
		}
		var_dump(isset($data['produk']));
		if($data['kategori'] == 'perbeli')
		redirect('promo/pembelian');
		else
		redirect('promo/produk');
	}

	public function delete($id){
		$this->promo_model->deleteDetail(array('id_promo' => $id));
		$this->promo_model->delete($id);
		echo json_encode("sukses");
	}

	
}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */