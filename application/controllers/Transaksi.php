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
		$this->load->model('platform_model');
	}

	public function index()
	{
		$data["marketplace"] = $this->platform_model->read();
		$this->load->view('transaksi',$data);
	}

	public function read()
	{
		// header('Content-type: application/json');
		if ($this->transaksi_model->read()->num_rows() > 0) {
			foreach ($this->transaksi_model->read()->result() as $transaksi) {
				$cetak = $transaksi->jenis_piutang == "lunas" ? '<a class="btn btn-sm btn-success" href="'.site_url('transaksi/cetak/').$transaksi->id.'">Cetak</a>' : '<a class="btn btn-sm btn-success" href="'.site_url('transaksi/lunas/').$transaksi->id.'">Lunas</a>';
				$tanggal = new DateTime($transaksi->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'total_bayar' => $transaksi->total_bayar,
					'nota' => $transaksi->nota,
					'jumlah_uang' => $transaksi->jumlah_uang,
					'diskon' => $transaksi->diskon,
					'pelanggan' => $transaksi->pelanggan,
					'action' => '
					<a class="btn btn-sm btn-success" href="'.site_url('transaksi/detail/').$transaksi->id.'">View</a>'.
					$cetak
					.'<button class="btn btn-sm btn-danger" onclick="remove('.$transaksi->id.')">Delete</button>'
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

	public function lunas($id){
		$transaksi = $this->transaksi_model->getAll($id);
		$this->transaksi_model->addKas(intval($transaksi->total_bayar) - intval($transaksi->piutang_kurang));
		$data = array(
			'jenis_piutang' => 'lunas',
		);
		$where = array(
			'id' => $id
		);
		$this->transaksi_model->update_data($where,$data,'transaksi');
		redirect("transaksi/cetak/".$id);
	}

	public function add()
	{
		$produks = json_decode($this->input->post('produk'));
		$tanggal = new DateTime($this->input->post('tanggal'));
		$bank = $this->input->post('jenis_bayar') == "cash" ? "" : $this->input->post('bank');
		$kurang = $this->input->post('jenis_piutang') == 'lunas' ? 0 : $this->input->post('piutang_kurang');
		$data = array(
			'tanggal' => $tanggal->format('Y-m-d H:i:s'),
			'total_bayar' => $this->input->post('total_bayar'),
			'jumlah_uang' => $this->input->post('jumlah_uang'),
			'diskon' => $this->input->post('diskon'),
			'pelanggan' => $this->input->post('pelanggan'),
			'nota' => $this->input->post('nota'),
			'kasir' => $this->session->userdata('id'),
			'marketplace' => $this->input->post('marketplace'),
			'jenis_piutang' => $this->input->post('jenis_piutang'),
			'piutang_kurang' => $kurang,
			'jenis_bayar' => $this->input->post('jenis_bayar'),
			'jenis_kirim' => $this->input->post('jenis_kirim'),
			'ongkir' => $this->input->post('ongkir'),
			'bank' => $bank,
		);
		if($this->input->post('jenis_piutang') == 'dp' || $this->input->post('jenis_piutang') == 'lunas')
			$this->transaksi_model->addKas(intval($data["total_bayar"]) - intval($data["piutang_kurang"]));
		
		if ($this->transaksi_model->create($data)) {
			$id_transaksi = $this->db->insert_id();
			foreach ($produks as $produk) {
				$detail = array(
					'id_transaksi' => $id_transaksi,
					'id_produk' => intval($produk->id_produk),
					'jumlah' => $produk->jumlah
				);
				$this->transaksi_model->createDetail($detail);
				$this->transaksi_model->removeStok(intval($produk->id_produk), $produk->jumlah);
				$this->transaksi_model->addTerjual(intval($produk->id_produk), $produk->jumlah);
				
			}
			echo json_encode($id_transaksi);
		}
		

	}

	public function detail($id){
		$data["id"] = $id;
		$query = $this->transaksi_model->query("
		select transaksi.*, pelanggan.nama as nama_pelanggan, platform.nama as nama_marketplace from transaksi join pelanggan on pelanggan.id = transaksi.pelanggan left join platform on transaksi.marketplace = platform.id where transaksi.id = $id
		");
		$data["transaksi"] = $query[0];
		$this->load->view('detail_order', $data);
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
		$transaksi = $this->transaksi_model->getAll($id);
		if ($this->transaksi_model->delete($id)) {
			$this->transaksi_model->removeKas(intval($transaksi->total_bayar));
			echo json_encode('sukses');
		}
	}

	public function cetak($id)
	{
		$produk = $this->transaksi_model->getAll($id);
		
		$tanggal = new DateTime($produk->tanggal);
		
		$produk->tanggal = $tanggal->format('d m Y H:i:s');

		$dataProduk = $this->transaksi_model->query("
		select jumlah, produk.* from detail_transaksi 
		join produk on produk.id = detail_transaksi.id_produk 
		where id_transaksi = $id
		");

		$data = array(
			'nota' => $produk->nota,
			'tanggal' => $produk->tanggal,
			'produk' => $dataProduk,
			'total' => $produk->total_bayar,
			'bayar' => $produk->jumlah_uang,
			'kembalian' => $produk->jumlah_uang - $produk->total_bayar,
			'kasir' => $produk->kasir,
			'level' => $produk->level,
			'nama_pelanggan' => $produk->nama_pelanggan,
			'jumlah_produk' => $produk->jumlah_produk,
			'jenis_bayar' => $produk->jenis_bayar,
			'bank' => $produk->bank,
			
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
		select laporan_harian.tanggal, 
			total_beli, 
			total_jual, 
			jumlah_transaksi, 
			(
				total_jual - total_beli - ifnull(sum(pengeluaran.nominal),0)
			) as laba_kotor ,
			ifnull(sum(pengeluaran.nominal),0) as total_pengeluaran
		from laporan_harian
		left join pengeluaran on date_format(pengeluaran.tanggal,'%d %b %Y') = laporan_harian.tanggal
		group by laporan_harian.tanggal
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
		select bulan, 
			total_beli, 
			total_jual, 
			jumlah_transaksi, 
			(
				total_jual - total_beli - sum(pengeluaran.nominal)
			) as laba_kotor ,
			sum(pengeluaran.nominal) as total_pengeluaran
		from laporan_bulanan
		join pengeluaran on date_format(pengeluaran.tanggal, '%M %Y') = bulan
		group by bulan
		";

		$data = array();
		
		foreach ($this->transaksi_model->query($query) as $transaksi) {
			$data[] = array(
				'bulan' => $transaksi->bulan,
				'total_beli' => $transaksi->total_beli,
				'total_jual' => $transaksi->total_jual,
				'total_pengeluaran' => $transaksi->total_pengeluaran,
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