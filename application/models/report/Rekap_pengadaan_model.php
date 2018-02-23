<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_pengadaan_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_rekapitulasi($config = array())
	{
		# Ambil data SPK
		$select 	 = "id,nomor,nilai,addendum_nilai,nama_perusahaan";
		$where 		 = array('is_deleted'=>0,'id_organisasi'=>$config['id_organisasi']);
		$where_query = "tanggal BETWEEN '".$config['periode_start']."' AND '".$config['periode_end']."' AND status_pengajuan = 2";
		$final 		 = $this->db->select($select)->where($where)->where($where_query)->get('spk')->result();

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
		$where    = "WHERE id_spk = {$id_spk}";
		$qa = "SELECT reg_induk, reg_barang, CONCAT(null) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM aset_a a JOIN kategori k ON a.id_kategori = k.id {$where}";
		$qb = "SELECT reg_induk, reg_barang, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM aset_b b JOIN kategori k ON b.id_kategori = k.id {$where}";
		$qc = "SELECT reg_induk, reg_barang, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM aset_c c JOIN kategori k ON c.id_kategori = k.id {$where}";
		$qd = "SELECT reg_induk, reg_barang, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM aset_d d JOIN kategori k ON d.id_kategori = k.id {$where}";
		$qe = "SELECT reg_induk, reg_barang, judul AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM aset_e e JOIN kategori k ON e.id_kategori = k.id {$where}";
		$query = "SELECT * FROM ({$qa} UNION {$qb} UNION {$qc} UNION {$qd} UNION {$qe}) AS q";
		$final->aset = $this->db->query($query)->result();

		# Ambil non aset
		$select = "id,nama,CONCAT(merk,' ',tipe) AS merk,nilai";
		$final->non_aset = $this->db->select($select)->where(array('id_spk'=>$id_spk))->get('aset_non')->result();

		#Ambil Kapitalisasi
		$query = $qe = "SELECT reg_induk, kap.nama AS judul, CONCAT(merk,' ',tipe) AS merk, jumlah, (jumlah*nilai+nilai_penunjang) AS nilai, {$kategori}  FROM aset_kapitalisasi kap JOIN kategori k ON kap.id_kategori = k.id {$where}";
		$final->kapitalisasi = $this->db->query($query)->result();

		return $final;
	}
}