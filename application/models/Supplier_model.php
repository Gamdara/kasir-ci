<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {

	private $table = 'supplier';

	public function tambah()
    {
        $data = array(
            'nama' => $this->input->post('nama', true),
            'alamat' => $this->input->post('alamat', true),
            'telepon' => $this->input->post('telp', true),
            'keterangan' => $this->input->post('ket', true)
        );
          $this->db->insert($this->table, $data);
    }

	public function viewsupplier()
	{
		return $this->db->get($this->table)->result_array();
	}

	public function delete($id_supplier)
    {
        $this->db->where('id', $id_supplier);
        return $this->db->delete($this->table);
    }

	function edit_data($where,$table){      
        return $this->db->get_where($table,$where);
    }
    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }

	public function getSupplier($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table);
	}

	public function search($search="")
	{
		$this->db->like('nama', $search);
		return $this->db->get($this->table)->result();
	}
    public function read()
	{
		return $this->db->get($this->table);
	}

}

/* End of file Supplier_model.php */
/* Location: ./application/models/Supplier_model.php */