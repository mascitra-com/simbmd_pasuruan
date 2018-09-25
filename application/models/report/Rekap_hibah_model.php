<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_hibah_model extends MY_Model {
	public $empty_substitution = "<i style='color:#b7b7b7'>(kosong)</i>";

	public function __construct()
	{
		parent::__construct();
	}

	public function get_rekapitulasi($config = array())
	{
		# Ambil data hibah
		$select 	 = "hibah.id,no_jurnal,tgl_jurnal, asal_penerimaan,no_serah_terima, tgl_serah_terima,keterangan, organisasi.nama";
		$where_query = "tgl_serah_terima BETWEEN '".$config['periode_start']."' AND '".$config['periode_end']."'";

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

		$final = $this->db->select($select)->join('organisasi','hibah.id_organisasi = organisasi.id')->where($where)->where($where_query)->get('hibah')->result();
		$final = $this->fill_empty_data($final);

		foreach ($final as $key => $value) {
			$value->rincian = $this->get_rincian($value->id);
		}

		return $final;
	}

	private function get_rincian($id_hibah)
	{
		$final = new StdClass();

		# Ambil aset
		$kategori = "kd_golongan, kd_bidang, kd_kelompok, kd_subkelompok, kd_subsubkelompok, k.nama";
		$where    = "WHERE id_hibah = {$id_hibah} AND id_spk IS NULL AND id_hapus IS NULL AND id_koreksi IS NULL";
		$qa = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_a a JOIN kategori k ON a.id_kategori = k.id {$where}";
		$qb = "SELECT reg_induk, reg_barang, kondisi, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_b b JOIN kategori k ON b.id_kategori = k.id {$where}";
		$qc = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM temp_aset_c c JOIN kategori k ON c.id_kategori = k.id {$where}";
		$qd = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM temp_aset_d d JOIN kategori k ON d.id_kategori = k.id {$where}";
		$qe = "SELECT reg_induk, reg_barang, kondisi, judul AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_e e JOIN kategori k ON e.id_kategori = k.id {$where}";
		$qg = "SELECT reg_induk, reg_barang, kondisi, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_g g JOIN kategori k ON g.id_kategori = k.id {$where}";
		$query = "SELECT * FROM ({$qa} UNION ALL {$qb} UNION ALL {$qc} UNION ALL {$qd} UNION ALL {$qe} UNION ALL {$qg}) AS q";
		$final->aset = $this->db->query($query)->result();
		$final->aset = $this->fill_empty_data($final->aset);

		#Ambil Kapitalisasi
		$where = "WHERE id_hibah = {$id_hibah} AND id_spk IS NULL";
		$query = "SELECT reg_induk, kap.nama_barang AS judul, CONCAT(merk,' ',tipe) AS merk, jumlah, (jumlah*nilai+nilai_penunjang) AS nilai, {$kategori} FROM aset_kapitalisasi kap JOIN kategori k ON kap.id_kategori = k.id {$where}";
		$final->kapitalisasi = $this->db->query($query)->result();
		$final->kapitalisasi = $this->fill_empty_data($final->kapitalisasi);

		return $final;
	}
}