<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model {

	private $table = 'karyawan';

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

	public function delete($id_karyawan)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->delete($this->table);
    }

	public function getKategori($id)
	{
		$this->db->where('id_karyawan', $id);
		return $this->db->get($this->table);
	}

	public function search($search="")
	{
		$this->db->like('id_karyawan', $search);
		return $this->db->get($this->table)->result();
	}

}

/* End of file Kategori_produk_model.php */
/* Location: ./application/models/Kategori_produk_model.php */