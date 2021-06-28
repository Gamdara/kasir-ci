<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model {

	private $table = 'pelanggan';

	public function tambah($data)
    {
          $this->db->insert($this->table, $data);
    }

	public function view()
	{
		return $this->db->get($this->table)->result_array();
	}

	public function delete($id_pelanggan)
    {
        $this->db->where('id', $id_pelanggan);
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