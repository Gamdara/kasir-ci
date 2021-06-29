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

	public function query($query)
	{
		$sql = $this->db->query($query);
		$data = array();
		foreach($sql->result() as $hasil){
			$data[] = $hasil;
		}
		return $data;
	}

	function edit_data($where,$table){      
        return $this->db->get_where($table,$where);
    }

	function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }

	public function addJumlah($id,$jumlah,$total)
	{
		$this->db->where('id', $id);
		$this->db->set('jumlah_uang', 'jumlah_uang+'.$jumlah, FALSE);
		
		return $this->db->update('transaksi');
	}
}

/* End of file Kategori_produk_model.php */
/* Location: ./application/models/Kategori_produk_model.php */

