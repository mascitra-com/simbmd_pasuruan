<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_transfer_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_rekapitulasi($config = array())
	{
		if ($config['jenis'] === '1') {
			$from = 'id_tujuan';
			$to = 'id_organisasi';
		}else{
			$from = 'id_organisasi';
			$to = 'id_tujuan';
		}

		# AMBIL DATA TRANSFER PER KELOMPOK
		$rekap = $this->db
		->select("{$to} AS to, nama")
		->where($from, $config['id_organisasi'])
		->join('organisasi','organisasi.id=transfer.'.$to)
		->where('status_pengajuan', '2')
		->where(" jurnal_tgl BETWEEN '".$config['periode_start']."' AND '".$config['periode_end']."' AND status_pengajuan = 2")
		->group_by($to)
		->get('transfer')
		->result();

		if (empty($rekap)) {
			return [];
		}

		# AMBIL DATA TRANSFER
		foreach ($rekap as $value) {
			$value->transfer = $this->db
			->where($from, $config['id_organisasi'])
			->where($to, $value->to)
			->where('status_pengajuan', '2')
			->where("jurnal_tgl BETWEEN '".$config['periode_start']."' AND '".$config['periode_end']."'")
			->get('transfer')
			->result();

			# AMBIL MASING2 RINCIAN
			$select = "CONCAT(kd_golongan,'.',kd_bidang,'.',kd_kelompok,'.',kd_subkelompok,'.',kd_subsubkelompok) AS kd_barang";
			$join	= "kategori k ON k.id = ast.id_kategori";

			foreach ($value->transfer as $item) {
				$item = $this->subtitute($item);

				$qa = "SELECT {$select},nama,reg_barang,reg_induk,nilai,CONCAT('-') AS keterangan FROM temp_aset_a ast JOIN {$join} WHERE id_transfer = {$item->id}";
				$qb = "SELECT {$select},CONCAT(nama,' ',merk,' ',tipe) AS nama,reg_barang,reg_induk,nilai,CONCAT(ukuran,' ',no_polisi,' ',no_rangka,' ',no_mesin) AS keterangan FROM temp_aset_b ast JOIN {$join} WHERE id_transfer = {$item->id}";
				$qc = "SELECT {$select},nama,reg_barang,reg_induk,(nilai+nilai_tambah) AS nilai,CONCAT('-') AS keterangan FROM temp_aset_c ast JOIN {$join} WHERE id_transfer = {$item->id}";
				$qd = "SELECT {$select},nama,reg_barang,reg_induk,(nilai+nilai_tambah) AS nilai,CONCAT('-') AS keterangan FROM temp_aset_d ast JOIN {$join} WHERE id_transfer = {$item->id}";
				$qe = "SELECT {$select},CONCAT(nama,' ',judul) AS nama,reg_barang,reg_induk,nilai,CONCAT(ukuran) AS keterangan FROM temp_aset_e ast JOIN {$join} WHERE id_transfer = {$item->id}";
				$qg = "SELECT {$select},CONCAT(merk,' ',tipe) AS nama,reg_barang,reg_induk,nilai,CONCAT(ukuran) AS keterangan FROM temp_aset_g ast JOIN {$join} WHERE id_transfer = {$item->id}";
				$query = "SELECT * FROM ({$qa} UNION ALL {$qb} UNION ALL {$qc} UNION ALL {$qd} UNION ALL {$qe} UNION ALL {$qg}) AS q";

				$item->rincian = $this->db->query($query)->result();
			}
		}
		
		return $rekap;
	}
}