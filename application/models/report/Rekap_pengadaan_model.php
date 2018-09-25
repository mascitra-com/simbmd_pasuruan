<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_pengadaan_model extends MY_Model {

	public $empty_substitution = "<i style='color:#b7b7b7'>(kosong)</i>";

	public function __construct()
	{
		parent::__construct();
	}

	public function get_rekapitulasi($config = array())
	{
		if ($config['pengelompokan']==1) {
			return $this->rekap_spk($config);
		}else{
			return $this->rekap_kategori($config);
		}
	}

	private function rekap_spk($config = array())
	{
		# Ambil data SPK
		$select 	 = "spk.id,nomor,nilai,addendum_nilai,nama_perusahaan,organisasi.nama";
		$where_query = "tanggal BETWEEN '".$config['periode_start']."' AND '".$config['periode_end']."'";

		switch ($config['id_organisasi']) {
			case 'all':
			$where = array('status_pengajuan'=>2);
			break;
			case '7.1':
			case '8.1':
			$kd = explode('.', $config['id_organisasi']);
			$where = array('status_pengajuan'=>2,'kd_bidang'=>$kd[0],'kd_unit'=>$kd[1]);
			break;
			default:
			$where = array('status_pengajuan'=>2,'id_organisasi'=>$config['id_organisasi']);
			break;
		}

		$final = $this->db->select($select)->join('organisasi','spk.id_organisasi = organisasi.id')->where($where)->where($where_query)->get('spk')->result();
		$final = $this->fill_empty_data($final);
		
		foreach ($final as $key => $value) {
			# Ambil SP2D
			$where = array('is_deleted'=>0, 'id_spk'=>$value->id);
			$value->sp2d 	= $this->db->select('nomor,nilai,kode_rekening')->where($where)->get('sp2d')->result();
			$value->rincian = $this->get_rincian($value->id);
		}

		return $final;
	}

	private function get_rincian($id_spk)
	{
		$final = new StdClass();

		# Ambil aset
		$kategori = "kd_golongan, kd_bidang, kd_kelompok, kd_subkelompok, kd_subsubkelompok, k.nama";
		$where    = "WHERE id_spk = {$id_spk} AND id_transfer IS NULL AND id_hapus IS NULL and id_koreksi IS NULL";
		$qa = "SELECT reg_induk, reg_barang, CONCAT(null) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori} FROM temp_aset_a a JOIN kategori k ON a.id_kategori = k.id {$where}";
		$qb = "SELECT reg_induk, reg_barang, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori} FROM temp_aset_b b JOIN kategori k ON b.id_kategori = k.id {$where}";
		$qc = "SELECT reg_induk, reg_barang, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori} FROM temp_aset_c c JOIN kategori k ON c.id_kategori = k.id {$where}";
		$qd = "SELECT reg_induk, reg_barang, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori} FROM temp_aset_d d JOIN kategori k ON d.id_kategori = k.id {$where}";
		$qe = "SELECT reg_induk, reg_barang, judul AS merk, CONCAT('1') AS jumlah, nilai, {$kategori} FROM temp_aset_e e JOIN kategori k ON e.id_kategori = k.id {$where}";
		$qg = "SELECT reg_induk, reg_barang, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori} FROM temp_aset_g g JOIN kategori k ON g.id_kategori = k.id {$where}";
		$query = "SELECT * FROM ({$qa} UNION ALL {$qb} UNION ALL {$qc} UNION ALL {$qd} UNION ALL {$qe} UNION ALL {$qg}) AS q";
		$final->aset = $this->db->query($query)->result();
		$final->aset = $this->fill_empty_data($final->aset);

		# Ambil non aset
		$select = "id,nama,CONCAT(merk,' ',tipe) AS merk,nilai";
		$final->non_aset = $this->db->select($select)->where(array('id_spk'=>$id_spk))->get('aset_non')->result();
		$final->non_aset = $this->fill_empty_data($final->non_aset);

		#Ambil Kapitalisasi
		$query = $qe = "SELECT reg_induk, kap.nama_barang_barang AS judul, CONCAT(merk,' ',tipe) AS merk, jumlah, (jumlah*nilai+nilai_penunjang) AS nilai, {$kategori}  FROM aset_kapitalisasi kap JOIN kategori k ON kap.id_kategori = k.id WHERE id_spk = {$id_spk}";
		$final->kapitalisasi = $this->db->query($query)->result();
		$final->kapitalisasi = $this->fill_empty_data($final->kapitalisasi);

		return $final;
	}

	private function rekap_kategori($config = array())
	{
		switch ($config['id_organisasi']) {
			case 'all':
			$where = 'status_pengajuan = 2';
			break;
			case '7.1':
			case '8.1':
			$kd = explode('.', $config['id_organisasi']);
			$where = "status_pengajuan = 2 AND kd_bidang = {$kd[0]} AND kd_unit = {$kd[1]}";
			break;
			default:
			$where = "status_pengajuan = 2 AND spk.id_organisasi = ".$config['id_organisasi'];
			break;
		}

		$select = 'kd_golongan AS kd1, kategori.kd_bidang AS kd2, kd_kelompok AS kd3';
		$where .= " AND spk.tanggal BETWEEN '".$config['periode_start']."' AND '".$config['periode_end']."'";
		$where .= " AND id_spk IS NOT NULL AND id_transfer IS NULL AND id_hapus IS NULL AND id_koreksi IS NULL";
		$join  = "spk ON id_spk = spk.id JOIN organisasi ON spk.id_organisasi = organisasi.id JOIN kategori ON id_kategori = kategori.id";
		$group = "kd_golongan, kategori.kd_bidang, kd_kelompok";

		$qa = "SELECT {$select}, SUM(temp_aset_a.nilai) AS jumlah FROM temp_aset_a JOIN {$join} WHERE {$where} GROUP BY {$group}";
		$qb = "SELECT {$select}, SUM(temp_aset_b.nilai) AS jumlah FROM temp_aset_b JOIN {$join} WHERE {$where} GROUP BY {$group}";
		$qc = "SELECT {$select}, SUM(temp_aset_c.nilai) AS jumlah FROM temp_aset_c JOIN {$join} WHERE {$where} GROUP BY {$group}";
		$qd = "SELECT {$select}, SUM(temp_aset_d.nilai) AS jumlah FROM temp_aset_d JOIN {$join} WHERE {$where} GROUP BY {$group}";
		$qe = "SELECT {$select}, SUM(temp_aset_e.nilai) AS jumlah FROM temp_aset_e JOIN {$join} WHERE {$where} GROUP BY {$group}";
		$qg = "SELECT {$select}, SUM(temp_aset_g.nilai) AS jumlah FROM temp_aset_g JOIN {$join} WHERE {$where} GROUP BY {$group}";
		$query = "SELECT kd1, kd2, kd3, SUM(jumlah) AS jumlah FROM ({$qa} UNION ALL {$qb} UNION ALL {$qc} UNION ALL {$qd} UNION ALL {$qe} UNION ALL {$qg}) AS q GROUP BY kd1, kd2, kd3";
		
		$data = $this->db->query($query)->result_array();

		foreach ($data as $index=>$value) {
			$data[$index]['nama'] = $this->db->select('nama')
			->where(array('kd_golongan'=>$value['kd1'],'kd_bidang'=>$value['kd2'],'kd_kelompok'=>$value['kd3']))
			->get('kategori')->result()[0]->nama;
		}

		return $data;
	}
}