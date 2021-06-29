<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {

	private $table = 'produk';

	public function view()
	{
		$this->db->select("produk.*, kategori_produk.kategori as kategori");
		$this->db->order_by('produk.id', 'ASC');
        return $this->db->from('produk')
          ->join('kategori_produk', 'produk.kategori=kategori_produk.id')
          ->get()
		  ->result_array();	  
	}

	public function get_kategori(){
		$query = $this->db->get('kategori_produk')->result();
		return $query;
	}

	public function tambah()
    {
		$barcode = $this->input->post('nama', true);
		$barcode = preg_replace('#[aeiou]+#i', '', $barcode);
		$barcode = preg_replace('/[0]/', '', $barcode );
		$barcode = strtoupper($barcode);

        $data = array(
            'nama_produk' => $this->input->post('nama', true),
			'barcode' => $barcode,
            'kategori' => $this->input->post('kategori', true),
            'harga_beli' => $this->input->post('beli', true),
			'harga_jual' => $this->input->post('jual', true),
			'harga_reseller' => $this->input->post('resell', true)
        );
          $this->db->insert($this->table, $data);
    }

	function edit_data($where,$table){  
        return $this->db->get_where($table,$where);
    }
    function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

	public function getProduk($id)
	{
		$this->db->select('produk.id, produk.barcode, produk.nama_produk, produk.harga_jual, produk.harga_beli, produk.stok, kategori_produk.id as kategori_id, kategori_produk.kategori, satuan_produk.id as satuan_id, satuan_produk.satuan');
		$this->db->from($this->table);
		$this->db->join('kategori_produk', 'produk.kategori = kategori_produk.id');
		$this->db->join('satuan_produk', 'produk.satuan = satuan_produk.id', 'left');
		$this->db->where('produk.id', $id);
		return $this->db->get();
	}

	public function getBarcode($search='')
	{
		$this->db->select('produk.id, produk.barcode, produk.nama_produk');
		$this->db->like('nama_produk', $search);
		return $this->db->get($this->table)->result();
	}

	public function getNama($id)
	{
		$this->db->select('nama_produk, stok');
		$this->db->where('id', $id);
		return $this->db->get($this->table)->row();
	}

	public function getStok($id)
	{
		$this->db->select('stok, nama_produk, harga_jual, harga_reseller, barcode');
		$this->db->where('id', $id);
		return $this->db->get($this->table)->row();
	}

	public function produkTerlaris()
	{
		return $this->db->query('SELECT produk.nama_produk, produk.terjual FROM `produk` 
		ORDER BY CONVERT(terjual,decimal)  DESC LIMIT 5')->result();
	}

	public function dataStok()
	{
		return $this->db->query('SELECT produk.nama_produk, produk.stok FROM `produk` ORDER BY CONVERT(stok, decimal) DESC LIMIT 50')->result();
	}
	

}

/* End of file Produk_model.php */
/* Location: ./application/models/Produk_model.php */