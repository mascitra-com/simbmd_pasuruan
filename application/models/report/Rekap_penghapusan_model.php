<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_penghapusan_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_rekapitulasi($config = array())
	{
		# Ambil data SPK
		$select 	 = "id,no_jurnal,tgl_jurnal,no_sk, tgl_sk,keterangan,alasan";
		$where 		 = array('is_deleted'=>0,'id_organisasi'=>$config['id_organisasi']);
		$where_query = "tgl_sk BETWEEN '".$config['periode_start']."' AND '".$config['periode_end']."' AND status_pengajuan = '2'";
		$final 		 = $this->db->select($select)->where($where)->where($where_query)->get('penghapusan')->result();

        foreach ($final as $key => $value) {
            $value->rincian = $this->get_rincian($value->id);
        }
		return $final;
	}

	private function get_rincian($id_hapus)
	{
		$final = new StdClass();

		# Ambil aset
		$kategori = "kd_golongan, kd_bidang, kd_kelompok, kd_subkelompok, kd_subsubkelompok, k.nama";
		$where    = "WHERE id_hapus= {$id_hapus} AND status_pengajuan = '2'";
		$qa = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_a a JOIN kategori k ON a.id_kategori = k.id JOIN penghapusan p ON a.id_hapus = p.id {$where}";
		$qb = "SELECT reg_induk, reg_barang, kondisi, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_b b JOIN kategori k ON b.id_kategori = k.id JOIN penghapusan p ON b.id_hapus = p.id {$where}";
		$qc = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM temp_aset_c c JOIN kategori k ON c.id_kategori = k.id JOIN penghapusan p ON c.id_hapus = p.id {$where}";
		$qd = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM temp_aset_d d JOIN kategori k ON d.id_kategori = k.id JOIN penghapusan p ON d.id_hapus = p.id {$where}";
		$qe = "SELECT reg_induk, reg_barang, kondisi, judul AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_e e JOIN kategori k ON e.id_kategori = k.id JOIN penghapusan p ON e.id_hapus = p.id {$where}";
		$query = "SELECT * FROM ({$qa} UNION {$qb} UNION {$qc} UNION {$qd} UNION {$qe}) AS q";
		$final->aset = $this->db->query($query)->result();

		return $final;
	}
}