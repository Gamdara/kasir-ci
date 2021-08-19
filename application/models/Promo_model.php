<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_model extends CI_Model {

	private $table = 'promo';
	
	public function insert($data){
		$this->db->insert($this->table, $data);
	}

	public function insertDetail($data){
		$this->db->insert('detail_promo', $data);
	}

	public function delete($id){
		$this->db->delete($this->table, array('id' => $id));
	}

	public function update($data,$id){
		$this->db->set($data);
		$this->db->where('id',$id);
		$this->db->update($this->table);
	}

	public function deleteDetail($where){
		$this->db->delete('detail_promo', $where);
	}

	public function getDetail($where){
		$this->db->select('produk.id,produk.nama_produk,detail_promo.min_jumlah');
		$this->db->from('detail_promo');
		$this->db->join('produk', 'detail_promo.id_produk = produk.id', 'left');
		$this->db->where($where);
		return $this->db->get()->result_array();
	}

	public function getAll(){
		$this->db->select('promo.*, group_concat(ifnull(produk.nama_produk, null) separator ", ") as nama_produk ');
		$this->db->from('promo');
		$this->db->join('detail_promo', 'detail_promo.id_promo = promo.id', 'left');
		$this->db->join('produk', 'detail_promo.id_produk = produk.id', 'left');
		$this->db->group_by('promo.id');
		return $this->db->get()->result_array();
	}

	public function getWhere($where){
		$this->db->select('promo.*, group_concat(ifnull(produk.nama_produk, null) separator ", ") as nama_produk ');
		$this->db->from('promo');
		$this->db->join('detail_promo', 'detail_promo.id_promo = promo.id', 'left');
		$this->db->join('produk', 'detail_promo.id_produk = produk.id', 'left');
		$this->db->where($where);
		$this->db->group_by('promo.id');
		return $this->db->get()->result_array();
	}

	public function getPromo($total, $produks = null){
		$this->db->select('promo.*, produk.nama_produk, detail_promo.min_jumlah,detail_promo.min_jumlah,');
		$this->db->from('promo');
		$this->db->join('detail_promo', 'detail_promo.id_promo = promo.id', 'left');
		$this->db->join('produk', 'detail_promo.id_produk = produk.id', 'left');
		$this->db->where("status",'aktif');
		$this->db->where("durasi >=",'current_date()',false);
		$this->db->where("min_beli <=",$total);
		$this->db->group_start();
		foreach ($produks as $produk) {
			$this->db->group_start();
			$this->db->or_where("detail_promo.id_produk",$produk['id_produk']);
			$this->db->where("detail_promo.min_jumlah <= ",$produk['jumlah']);
			$this->db->group_end();
		}
		$this->db->or_where("detail_promo.id_produk",null);
		$this->db->group_end();
		return $this->db->get()->result_array();
	}
}

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */