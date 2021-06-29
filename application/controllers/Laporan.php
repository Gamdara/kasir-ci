<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('laporan_model');
		$this->load->model('transaksi_model');
	}

	public function pengeluaran()
	{
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->view('laporan_pengeluaran');
	}

    public function getpengeluaran(){
		header('Content-type: application/json');
		$data = array();
		$no = 0;
		foreach ($this->laporan_model->read('pengeluaran') as $pengeluaran) {
			$id = $pengeluaran["id"];
			$pengeluaran["no"] = ++$no;
			$pengeluaran['action'] = "
			    <button type='submit'  class='btn btn-sm btn-primary' name='edit' onclick='del($id)'>Hapus</button>
			";
			$data[] = $pengeluaran;
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	public function addpengeluaran(){
		$tanggal = new DateTime($this->input->post('tanggal'));
		$data = array(
			"tanggal" => $tanggal->format('Y-m-d H:i:s'),
			"nominal" => $this->input->post('nominal'),
			"jenis_bayar" => $this->input->post('jenis_bayar'),
			"keterangan" => $this->input->post('keterangan'),
		);
		// $data = $this->input->post();
		// $data['tanggal'] = $tanggal->format('Y-m-d H:i:s');
		$this->transaksi_model->removeKas($this->input->post('nominal'));
		if ($this->laporan_model->create('pengeluaran',$data)) {
			echo json_encode($data);
		}
	}

	public function deletepengeluaran($id){
		$this->laporan_model->delete('pengeluaran',$id);
		echo json_encode($id);
	}

	public function deletepiutang($id){
		$this->laporan_model->delete('transaksi',$id);
		echo json_encode($id);
	}

	public function piutang(){
		$this->load->view('laporan_piutang');
	}

	public function list_refund(){
		$this->load->view('laporan_refund');
	}

	public function getpiutang(){
		header('Content-type: application/json');
		$data = array();
		$no = 0;
		$piutangs = $this->laporan_model->query("select * from transaksi where jenis_piutang = 'dp'");
		foreach ($piutangs as $piutang) {
			$piutang->no = ++$no;
			$piutang->action = "
				<a href='".base_url('laporan/lunas/'.$piutang->id)."'><button type='submit'  class='btn btn-sm btn-primary' name='edit'>Lunas</button></a>
			    <button type='submit' onclick='del($piutang->id)'  class='btn btn-sm btn-primary' name='edit'>Hapus</button>
			";
			$data[] = $piutang;
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}

	function lunas($id){
		$where = array('id' => $id);
		$data['transaksi'] = $this->laporan_model->edit_data($where,'transaksi')->result();
		$this->load->view('piutang_lunas',$data);
	}

	function bayar($id){
		$where = array('id' => $id);
		$bank = $this->input->post('jenis_bayar') == "cash" ? "" : $this->input->post('bank');
		$data = array(
			'piutang_kurang' => 0,
			'jenis_bayar' => $this->input->post('jenis_bayar'),
			'jenis_piutang' => 'lunas',
			'bank' => $bank,
		);
	 
		$where = array(
			'id' => $id
		);
		$this->laporan_model->update_data($where,$data,'transaksi');
		$this->laporan_model->addJumlah($id,$this->input->post('jumlah_uang'),$this->input->post('total_bayar'));
		$this->transaksi_model->addKas();
		
		echo json_encode($id);
	}

	function refunded($id){
		$transaksi = $this->transaksi_model->getAll($id);
		if($transaksi->jenis_piutang == "lunas" || $transaksi->jenis_piutang == "dp")
			$this->transaksi_model->removeKas(intval($transaksi->total_bayar) - intval($transaksi->piutang_kurang));
		$where = array('id' => $id);
		$data = array(
			'jenis_piutang' => 'refund',
		);
	 
		$where = array(
			'id' => $id
		);
	 
		$this->laporan_model->update_data($where,$data,'transaksi');
		$add = array(
			"id_transaksi" => $id,
			"tanggal" => date("Y-m-d")
		);

		$barangs = $this->laporan_model->query("select * from detail_transaksi where id_transaksi = $id ");
		foreach ($barangs as $barang) {
			$this->transaksi_model->addStok(intval($barang->id_produk), $barang->jumlah);
			$this->transaksi_model->addTerjual(intval($barang->id_produk), $barang->jumlah * -1);
		}

		$this->laporan_model->create('refund',$add);
		echo json_encode($transaksi->jenis_piutang);
	}

	public function refund($id){
		$data["id"] = $id;
		$query = $this->laporan_model->query("
		select transaksi.*, pelanggan.nama as nama_pelanggan, platform.nama as nama_marketplace, refund.tanggal as tgl_refund 
		from transaksi 
		join pelanggan on pelanggan.id = transaksi.pelanggan left 
		join platform on transaksi.marketplace = platform.id  
		join refund on refund.id_transaksi = $id
		where transaksi.id = $id
		");
		$data["transaksi"] = $query[0];
		$this->load->view('detail_refund', $data);
	}

	public function getrefund(){
		header('Content-type: application/json');
		$data = array();
		$no = 0;
		$piutangs = $this->laporan_model->query("select transaksi.*, refund.tanggal as tgl_refund from transaksi join refund on transaksi.id = refund.id_transaksi where jenis_piutang = 'refund'");
		foreach ($piutangs as $piutang) {
			$piutang->no = ++$no;
			$piutang->total_refund = $piutang->total_bayar - $piutang->piutang_kurang;
			
			$piutang->action = "
			    <a href='".base_url('laporan/refund/'.$piutang->id)."'><button type='submit'  class='btn btn-sm btn-primary' name='edit'>Detail</button></a>
			";
			$data[] = $piutang;
		}
		$stok_masuk = array(
			'data' => $data
		);
		echo json_encode($stok_masuk);
	}
}

/* End of file Laporan_stok_masuk.php */
/* Location: ./application/controllers/Laporan_stok_masuk.php */