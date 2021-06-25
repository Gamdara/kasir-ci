<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

	// private $table = 'gudang';

	public function create($table, $data)
	{
		return $this->db->insert($table, $data);
	}

	public function read($table)
	{
		return $this->db->get($table)->result_array();
	}

	public function delete($table, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }

}

/* End of file Kategori_produk_model.php */
/* Location: ./application/models/Kategori_produk_model.php */