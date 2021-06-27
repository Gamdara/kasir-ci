<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('pelanggan_model');
	}

	public function index()
	{
		$data['pelanggan'] = $this->pelanggan_model->view();
        $this->load->view('pelanggan', $data);
	}

	public function add()
	{
        $validation = $this->form_validation; //untuk menghemat penulisan kode

        $validation->set_rules('nama', 'Nama', 'required');
        $validation->set_rules('jk', 'Jenis Kelamin', 'required');
        $validation->set_rules('alamat', 'Telepon', 'required');
        $validation->set_rules('telp', 'Keterangan', 'required');

        if($validation->run() == FALSE) //jika form validation gagal tampilkan kembali form tambahnya
        {
            $this->load->view('tambah_pelanggan');
        } else {
			$data = array(
				'nama' => $this->input->post('nama', true),
				'jenis_kelamin' => $this->input->post('jk', true),
				'alamat' =>   $this->input->post('alamat', true),
				'telepon' => $this->input->post('telp', true),
				'level' => $this->input->post('level', true)
			);
          $this->pelanggan_model->tambah($data);
          redirect('pelanggan');
        }
	}

	public function delete($id_pelanggan)
	{
		$this->pelanggan_model->delete($id_pelanggan);
		echo '<script>
                alert("Sukses Menghapus Data ");
                window.location="'.base_url('pelanggan').'"
            </script>';
	}

	function edit($id_pelanggan){
		$where = array('id' => $id_pelanggan);
		$data['pelanggan'] = $this->pelanggan_model->edit_data($where,'pelanggan')->result();
		$this->load->view('edit_pelanggan',$data);
		}
	
	function update(){
			$id = $this->input->post('id');
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$telp = $this->input->post('telp');
			$level = $this->input->post('level');
			
	
			$data = array(
				'nama' => $nama,
				'alamat' => $alamat,
				'telepon' => $telp,
				'level' => $level,
			);
		 
			$where = array(
				'id' => $id
			);
		 
			$this->pelanggan_model->update_data($where,$data,'pelanggan');
			redirect('pelanggan');
		}

	/*public function get_supplier()
	{
		$id = $this->input->post('id');
		$supplier = $this->supplier_model->getSupplier($id);
		if ($supplier->row()) {
			echo json_encode($supplier->row());
		}
	}*/

	// public function search()
	// {
	// 	header('Content-type: application/json');
	// 	$supplier = $this->input->post('supplier');
	// 	$search = $this->supplier_model->search($supplier);
	// 	foreach ($search as $supplier) {
	// 		$data[] = array(
	// 			'id' => $supplier->id,
	// 			'text' => $supplier->nama
	// 		);
	// 	}
	// 	echo json_encode($data);
	// }

	public function search()
	{
		header('Content-type: application/json');
		$pelanggan = $this->input->post('pelanggan');
		$search = $this->pelanggan_model->search($pelanggan);
		foreach ($search as $pelanggan) {
			$data[] = array(
				'id' => $pelanggan->id,
				'text' => $pelanggan->nama." (".$pelanggan->level.")"
			);
		}
		echo json_encode($data);
	}

}  

/* End of file Supplier.php */
/* Location: ./application/controllers/Supplier.php */