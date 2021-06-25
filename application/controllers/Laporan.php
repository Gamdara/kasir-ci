<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('laporan_model');
	}

	public function pengeluaran()
	{
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->view('laporan_pengeluaran');
	}

    public function getpengeluaran(){
		header('Content-type: application/json');
		$data = array();
		$no = 0;
		foreach ($this->laporan_model->read('pengeluaran') as $pengeluaran) {
			$pengeluaran["no"] = ++$no;
			$pengeluaran['action'] = "
			    <a href='".base_url('laporan/deletepengeluaran/'.$pengeluaran['id'])."'><button type='submit'  class='btn btn-sm btn-primary' name='edit'>Hapus</button></a>
			";
			$data[] = $pengeluaran;
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	public function addpengeluaran(){
		$tanggal = new DateTime($this->input->post('tanggal'));
		$data = array(
			"tanggal" => $tanggal->format('Y-m-d H:i:s'),
			"nominal" => $this->input->post('nominal'),
			"jenis_bayar" => $this->input->post('jenis_bayar'),
			"keterangan" => $this->input->post('keterangan'),
		);
		// $data = $this->input->post();
		// $data['tanggal'] = $tanggal->format('Y-m-d H:i:s');
		if ($this->laporan_model->create('pengeluaran',$data)) {
			echo json_encode($data);
		}
	}

	public function deletepengeluaran($id){
		$this->laporan_model->delete('pengeluaran',$id);
		redirect('laporan/pengeluaran');
	}
}

/* End of file Laporan_stok_masuk.php */
/* Location: ./application/controllers/Laporan_stok_masuk.php */