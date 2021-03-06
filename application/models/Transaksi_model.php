<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

	private $table = 'transaksi';

	public function removeStok($id, $stok)
	{
		$this->db->where('id', $id);
		$this->db->set('stok', 'stok-'.$stok, FALSE);
		return $this->db->update('produk');
	}

	public function addStok($id, $stok)
	{
		$this->db->where('id', $id);
		$this->db->set('stok', 'stok+'.$stok, FALSE);
		return $this->db->update('produk');
	}

	public function createDetail($data)
	{
		return $this->db->insert("detail_transaksi", $data);
	}

	public function addTerjual($id, $jumlah)
	{
		$this->db->where('id', $id);
		$this->db->set('terjual', 'terjual+'.$jumlah, FALSE);
		return $this->db->update('produk');
	}

	public function removeTerjual($id, $jumlah)
	{
		$this->db->where('id', $id);
		$this->db->set('terjual', 'terjual-'.$jumlah, FALSE);
		return $this->db->update('produk');
	}

	public function create($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		$this->db->select('transaksi.id,transaksi.nota, transaksi.tanggal, transaksi.total_bayar, transaksi.jumlah_uang, transaksi.diskon,transaksi.jenis_piutang, pelanggan.nama as pelanggan');
		$this->db->from($this->table);
		$this->db->join('pelanggan', 'transaksi.pelanggan = pelanggan.id', 'left outer');
		$this->db->where("transaksi.jenis_piutang !=", "refund");
		$this->db->where("transaksi.jenis_piutang !=", "dp");
		$this->db->where("transaksi.jenis_piutang !=", "full");
		
		return $this->db->get();
	}

	public function delete($id)
	{
		$this->db->where('id_transaksi', $id);
		$this->db->delete("detail_transaksi");
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

	public function getProduk($barcode, $qty)
	{
		$total = explode(',', $qty);
		foreach ($barcode as $key => $value) {
			$this->db->select('nama_produk');
			$this->db->where('id', $value);
			$data[] = '<tr><td>'.$this->db->get('produk')->row()->nama_produk.' ('.$total[$key].')</td></tr>';
		}
		return join($data);
	}

	public function getDetail($id){
		$this->db->select('detail_transaksi.jumlah, transaksi.*, produk.*');
		$this->db->from('detail_transaksi');
		$this->db->join('transaksi', 'transaksi.id = detail_transaksi.id_transaksi');
		$this->db->join('produk', 'produk.id = detail_transaksi.id_produk');		
		$this->db->where('detail_transaksi.id_transaksi', $id);
		return $this->db->get();
	}

	public function penjualanBulan($date)
	{
		$qty = $this->db->query("SELECT qty FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$date'")->result();
		$d = [];
		$data = [];
		foreach ($qty as $key) {
			$d[] = explode(',', $key->qty);
		}
		foreach ($d as $key) {
			$data[] = array_sum($key);
		}
		return $data;
	}

	public function transaksiHari($hari)
	{
		return $this->db->query("SELECT COUNT(*) AS total FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari'")->row();
	}

	public function query($query)
	{
		$sql = $this->db->query($query);
		$data = array();
		foreach($sql->result() as $transaksi){
			$data[] = $transaksi;
		}
		return $data;
	}

	public function transaksiTerakhir($hari)
	{
		return $this->db->query("SELECT transaksi.qty FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari' LIMIT 1")->row();
	}

	public function getAll($id)
	{
		$this->db->select('transaksi.nota,transaksi.ongkir, transaksi.tanggal, transaksi.total_bayar, transaksi.bank, transaksi.jenis_bayar, transaksi.jumlah_uang,transaksi.piutang_kurang,transaksi.jenis_piutang, pengguna.nama as kasir, pelanggan.nama as nama_pelanggan, pelanggan.level as level, sum(jumlah) as jumlah_produk');
		$this->db->from('transaksi');
		$this->db->join('pengguna', 'transaksi.kasir = pengguna.id');
		$this->db->join('pelanggan', 'transaksi.pelanggan = pelanggan.id');
		$this->db->join('detail_transaksi', 'transaksi.id = detail_transaksi.id_transaksi');
		
		$this->db->where('transaksi.id', $id);
		return $this->db->get()->row();
	}

	public function getName($barcode)
	{
		foreach ($barcode as $b) {
			$this->db->select('nama_produk, harga_jual');
			$this->db->where('id', $b);
			$data[] = $this->db->get('produk')->row();
		}
		return $data;
	}

	function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }

	public function removeKas($kas)
	{
		$this->db->where('id', 1);
		$this->db->set('kas', 'kas-'.$kas, FALSE);
		return $this->db->update('toko');
	}

	public function addKas($kas)
	{
		$this->db->where('id', 1);
		$this->db->set('kas', 'kas+'.$kas, FALSE);
		return $this->db->update('toko');
	}
}

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */