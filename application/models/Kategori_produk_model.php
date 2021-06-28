<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_produk_model extends CI_Model {

	private $table = 'kategori_produk';

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		return $this->db->get($this->table)->result_array();
	}

	/*public function delete($id)
	{
		$this->db->where('id_kategori', $id);
		return $this->db->delete($this->table);
	}*/

	public function delete($id_kategori)
    {
        $this->db->where('id', $id_kategori);
        $this->db->delete($this->table);
    }

	public function getKategori($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table);
	}

	public function search($search="")
	{
		$this->db->like('kategori', $search);
		return $this->db->get($this->table)->result();
	}

}

/* End of file Kategori_produk_model.php */
/* Location: ./application/models/Kategori_produk_model.php */