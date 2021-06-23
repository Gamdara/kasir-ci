<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('transaksi_model');
	}

	public function index()
	{
		$this->load->view('transaksi');
	}

	public function read()
	{
		// header('Content-type: application/json');
		if ($this->transaksi_model->read()->num_rows() > 0) {
			foreach ($this->transaksi_model->read()->result() as $transaksi) {
				$tanggal = new DateTime($transaksi->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'total_bayar' => $transaksi->total_bayar,
					'jumlah_uang' => $transaksi->jumlah_uang,
					'diskon' => $transaksi->diskon,
					'pelanggan' => $transaksi->pelanggan,
					'action' => '<a class="btn btn-sm btn-success" href="'.site_url('transaksi/detail/').$transaksi->id.'">View</a> <a class="btn btn-sm btn-success" href="'.site_url('transaksi/cetak/').$transaksi->id.'">Print</a> <button class="btn btn-sm btn-danger" onclick="remove('.$transaksi->id.')">Delete</button>'
				);
			}
		} else {
			$data = array();
		}
		$transaksi = array(
			'data' => $data
		);
		echo json_encode($transaksi);
	}

	public function add()
	{
		$produks = json_decode($this->input->post('produk'));
		$tanggal = new DateTime($this->input->post('tanggal'));
		$data = $this->input->post('form');
		
		$data = array(
			'tanggal' => $tanggal->format('Y-m-d H:i:s'),
			'total_bayar' => $this->input->post('total_bayar'),
			'jumlah_uang' => $this->input->post('jumlah_uang'),
			'diskon' => $this->input->post('diskon'),
			'pelanggan' => $this->input->post('pelanggan'),
			'nota' => $this->input->post('nota'),
			'kasir' => $this->session->userdata('id')
		);
		if ($this->transaksi_model->create($data)) {
			$id_transaksi = $this->db->insert_id();
			foreach ($produks as $produk) {
				$detail = array(
					'id_transaksi' => $id_transaksi,
					'id_produk' => $produk->id_produk,
					'jumlah' => $produk->jumlah
				);
				$this->transaksi_model->createDetail($detail);
				$this->transaksi_model->removeStok($produk->id_produk, $produk->jumlah);
				$this->transaksi_model->addTerjual($produk->id_produk, $produk->jumlah);
			}
			echo json_encode($id_transaksi);
		}
		

	}

	public function detail($id){
		$data["id"] = $id;
		$this->load->view('detail_transaksi', $data);
	}

	public function getdetail($id){
		if ($this->transaksi_model->getDetail($id)->num_rows() > 0) {
			foreach ($this->transaksi_model->getDetail($id)->result() as $detail) {
				$data[] = array(
					'barcode' => $detail->barcode,
					'nama_produk' => $detail->nama_produk,
					'jumlah' => $detail->jumlah,
					'harga_jual' => $detail->harga_jual,
					'subtotal' => $detail->jumlah * $detail->harga_jual
				);
			}
		} else {
			$data = array();
		}
		$transaksi = array(
			'data' => $data
		);
		echo json_encode($transaksi);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		if ($this->transaksi_model->delete($id)) {
			echo json_encode('sukses');
		}
	}

	public function cetak($id)
	{
		$produk = $this->transaksi_model->getAll($id);
		
		$tanggal = new DateTime($produk->tanggal);
		$barcode = explode(',', $produk->barcode);
		$qty = explode(',', $produk->qty);

		$produk->tanggal = $tanggal->format('d m Y H:i:s');

		$dataProduk = $this->transaksi_model->getName($barcode);
		foreach ($dataProduk as $key => $value) {
			$value->total = $qty[$key];
			$value->harga_jual = $value->harga_jual * $qty[$key];
		}

		$data = array(
			'nota' => $produk->nota,
			'tanggal' => $produk->tanggal,
			'produk' => $dataProduk,
			'total' => $produk->total_bayar,
			'bayar' => $produk->jumlah_uang,
			'kembalian' => $produk->jumlah_uang - $produk->total_bayar,
			'kasir' => $produk->kasir
		);
		$this->load->view('cetak', $data);
	}

	public function penjualan_bulan()
	{
		header('Content-type: application/json');
		$day = $this->input->post('day');
		foreach ($day as $key => $value) {
			$now = date($day[$value].' m Y');
			if ($qty = $this->transaksi_model->penjualanBulan($now) !== []) {
				$data[] = array_sum($this->transaksi_model->penjualanBulan($now));
			} else {
				$data[] = 0;
			}
		}
		echo json_encode($data);
	}

	public function gethari()
	{
		$query = "
		select date_format(transaksi.tanggal,'%d %b %Y') as tanggal, 
			sum(produk.harga_beli) as total_beli, 
			sum(produk.harga_jual) as total_jual, 
			sum(transaksi.id) as jumlah_transaksi, 
			(sum(produk.harga_jual) - sum(produk.harga_beli)) as laba_kotor 
		from detail_transaksi
		join transaksi on transaksi.id = detail_transaksi.id_transaksi
		join produk on detail_transaksi.id_produk = produk.id
		group by transaksi.id
		";

		$data = array();
		
		foreach ($this->transaksi_model->query($query) as $transaksi) {
			$data[] = array(
				'tanggal' => $transaksi->tanggal,
				'total_beli' => $transaksi->total_beli,
				'total_jual' => $transaksi->total_jual,
				'jumlah_transaksi' => $transaksi->jumlah_transaksi,
				'laba' => $transaksi->laba_kotor,
			);
		}

		$transaksi = array(
			'data' => $data
		);
		echo json_encode($transaksi);
	}

	public function getbulan()
	{
		$query = "
		select date_format(tanggal, '%M %Y') as bulan, 
			sum(total_beli) as total_beli, 
			sum(total_jual) as total_jual, 
			sum(jumlah_transaksi) as jumlah_transaksi, 
			(sum(total_jual) - sum(total_beli)) as laba_kotor 
		from laporan_harian
		group by date_format(tanggal, '%M %Y')
		";

		$data = array();
		
		foreach ($this->transaksi_model->query($query) as $transaksi) {
			$data[] = array(
				'bulan' => $transaksi->bulan,
				'total_beli' => $transaksi->total_beli,
				'total_jual' => $transaksi->total_jual,
				'total_pengeluaran' => 0,
				'jumlah_transaksi' => $transaksi->jumlah_transaksi,
				'laba' => $transaksi->laba_kotor,
			);
		}

		$transaksi = array(
			'data' => $data
		);
		echo json_encode($transaksi);
	}

	public function transaksi_terakhir($value='')
	{
		header('Content-type: application/json');
		$now = date('d m Y');
		foreach ($this->transaksi_model->transaksiTerakhir($now) as $key) {
			$total = explode(',', $key);
		}
		echo json_encode($total);
	}

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */