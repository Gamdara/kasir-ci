<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang_model extends CI_Model {

	private $table = 'gudang';

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		return $this->db->get($this->table)->result_array();
	}

	public function delete($id_gudang)
    {
        $this->db->where('id_gudang', $id_gudang);
        $this->db->delete($this->table);
    }

}

/* End of file Kategori_produk_model.php */
/* Location: ./application/models/Kategori_produk_model.php */