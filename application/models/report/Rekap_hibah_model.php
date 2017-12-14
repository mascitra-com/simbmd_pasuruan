<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_hibah_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_rekapitulasi($config = array())
	{
		# Ambil data SPK
		$select 	 = "id,no_jurnal,asal_penerimaan,tgl_serah_terima";
		$where 		 = array('is_deleted'=>0,'id_organisasi'=>$config['id_organisasi']);
		$where_query = "tgl_serah_terima BETWEEN '".$config['periode_start']."' AND '".$config['periode_end']."'";
		$final 		 = $this->db->select($select)->where($where)->where($where_query)->get('hibah')->result();

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
		$where    = "WHERE id_hibah= {$id_hibah}";
		$qa = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM aset_a a JOIN kategori k ON a.id_kategori = k.id {$where}";
		$qb = "SELECT reg_induk, reg_barang, kondisi, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM aset_b b JOIN kategori k ON b.id_kategori = k.id {$where}";
		$qc = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM aset_c c JOIN kategori k ON c.id_kategori = k.id {$where}";
		$qd = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM aset_d d JOIN kategori k ON d.id_kategori = k.id {$where}";
		$qe = "SELECT reg_induk, reg_barang, kondisi, judul AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM aset_e e JOIN kategori k ON e.id_kategori = k.id {$where}";
		$query = "SELECT * FROM ({$qa} UNION {$qb} UNION {$qc} UNION {$qd} UNION {$qe}) AS q";
		$final->aset = $this->db->query($query)->result();

		# Ambil non aset
		$select = "id,nama,CONCAT(merk,' ',tipe) AS merk,nilai";
		$final->non_aset = $this->db->select($select)->where(array('id_hibah'=>$id_hibah))->get('aset_non')->result();

		#Ambil Kapitalisasi
		$query = $qe = "SELECT reg_induk, kap.nama AS judul, CONCAT(merk,' ',tipe) AS merk, jumlah, (jumlah*nilai+nilai_penunjang) AS nilai, {$kategori}  FROM kapitalisasi kap JOIN kategori k ON kap.id_kategori = k.id {$where}";
		$final->kapitalisasi = $this->db->query($query)->result();

		return $final;
	}
}