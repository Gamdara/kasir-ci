<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('reseller_model');
	}

	public function index()
	{
		$data['reseller'] = $this->reseller_model->view();
        $this->load->view('reseller', $data);
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
            $this->load->view('tambah_reseller');
        } else {
          $this->reseller_model->tambah();
          redirect('reseller');
        }
	}

	public function delete($id_reseller)
	{
		$this->reseller_model->delete($id_reseller);
		echo '<script>
                alert("Sukses Menghapus Data ");
                window.location="'.base_url('reseller').'"
            </script>';
	}

	function edit($id_reseller){
		$where = array('id_reseller' => $id_reseller);
		$data['reseller'] = $this->reseller_model->edit_data($where,'master.reseller')->result();
		$this->load->view('edit_reseller',$data);
		}
	
	function update(){
			$id_reseller = $this->input->post('id_reseller');
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$telp = $this->input->post('telp');
	
			$data = array(
				'nama' => $nama,
				'alamat' => $alamat,
				'telepon' => $telp
			);
		 
			$where = array(
				'id_reseller' => $id_reseller
			);
		 
			$this->reseller_model->update_data($where,$data,'master.reseller');
			redirect('reseller');
		}

	/*public function get_supplier()
	{
		$id = $this->input->post('id');
		$supplier = $this->supplier_model->getSupplier($id);
		if ($supplier->row()) {
			echo json_encode($supplier->row());
		}
	}

	public function search()
	{
		header('Content-type: application/json');
		$supplier = $this->input->post('supplier');
		$search = $this->supplier_model->search($supplier);
		foreach ($search as $supplier) {
			$data[] = array(
				'id' => $supplier->id,
				'text' => $supplier->nama
			);
		}
		echo json_encode($data);
	}*/

}  

/* End of file Supplier.php */
/* Location: ./application/controllers/Supplier.php */