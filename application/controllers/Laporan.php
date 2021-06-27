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

	public function deletepiutang($id){
		$this->laporan_model->delete('piutang',$id);
		redirect('laporan/piutang');
	}

	public function piutang(){
		$this->load->view('laporan_piutang');
	}

	public function getpiutang(){
		header('Content-type: application/json');
		$data = array();
		$no = 0;
		$piutangs = $this->laporan_model->query("select * from transaksi where jenis_piutang = 'dp'");
		foreach ($piutangs as $piutang) {
			$piutang->no = ++$no;
			$piutang->action = "
				<a href='".base_url('laporan/lunas/'.$piutang->id)."'><button type='submit'  class='btn btn-sm btn-primary' name='edit'>Lunas</button></a>
			    <a href='".base_url('laporan/deletepiutang/'.$piutang->id)."'><button type='submit'  class='btn btn-sm btn-primary' name='edit'>Hapus</button></a>
			";
			$data[] = $piutang;
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	function lunas($id){
		$where = array('id' => $id);
		$data['transaksi'] = $this->laporan_model->edit_data($where,'transaksi')->result();
		$this->load->view('piutang_lunas',$data);
	}

	function bayar($id){
		$where = array('id' => $id);
		
		$data = array(
			'piutang_kurang' => 0,
			'jenis_bayar' => $this->input->post('jenis_bayar'),
			'jenis_piutang' => 'lunas',
			'bank' => $this->input->post('bank'),
		);
	 
		$where = array(
			'id' => $id
		);
	 
		$this->laporan_model->update_data($where,$data,'transaksi');
		$this->laporan_model->addJumlah($id,$this->input->post('jumlah_uang'));
		
		echo json_encode($id);
	}
}

/* End of file Laporan_stok_masuk.php */
/* Location: ./application/controllers/Laporan_stok_masuk.php */