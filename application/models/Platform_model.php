<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Platform_model extends CI_Model {

	private $table = 'platform';

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		return $this->db->get($this->table)->result_array();
	}

	public function add()
    {
		var_dump($this->input);
        $data = array(
            'nama' => $this->input->post('nama', true),
        );
          $this->db->insert($this->table, $data);
    }

	public function delete($id_platform)
    {
        $this->db->where('id', $id_platform);
        $this->db->delete($this->table);
    }

	public function getKategori($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table);
	}

	public function search($search="")
	{
		$this->db->like('nama', $search);
		return $this->db->get($this->table)->result();
	}

}

/* End of file Kategori_produk_model.php */
/* Location: ./application/models/Kategori_produk_model.php */