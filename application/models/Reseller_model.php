<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_model     extends CI_Model {

	private $table = 'reseller';

	public function tambah()
    {
        $data = array(
            'nama' => $this->input->post('nama', true),
            'jenis_kelamin' => $this->input->post('jk', true),
            'alamat' =>   $this->input->post('alamat', true),
            'telepon' => $this->input->post('telp', true)
        );
          $this->db->insert($this->table, $data);
    }

	public function view()
	{
		return $this->db->get($this->table)->result_array();
	}

	public function delete($id_reseller)
    {
        $this->db->where('id', $id_reseller);
        $this->db->delete($this->table);
    }
  
	function edit_data($where,$table){      
        return $this->db->get_where($table,$where);
    }
    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }

	public function search($search="")
	{
		$this->db->like('nama', $search);
		return $this->db->get($this->table)->result();
	}

}

/* End of file Supplier_model.php */
/* Location: ./application/models/Supplier_model.php */