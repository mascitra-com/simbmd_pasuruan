<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_inventarisasi_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	public function report($conf = array())
	{
		$select 	 = "inventarisasi.id,no_ba,tgl_ba,keterangan, organisasi.nama";
		$where_query = "tgl_ba BETWEEN '".$conf['periode_start']."' AND '".$conf['periode_end']."' AND status_pengajuan = 2";

		switch ($conf['id_organisasi']) {
			case 'all':
			$where = array('status_pengajuan'=>2);
			break;
			case '7.1':
			case '8.1':
			$kd = explode('.', $conf['id_organisasi']);
			$where = array('status_pengajuan'=>2,'kd_bidang'=>$kd[0],'kd_unit'=>$kd[1]);
			break;
			default:
			$where = array('status_pengajuan'=>2,'id_organisasi'=>$conf['id_organisasi']);
			break;
		}

		$final = $this->db->select($select)->join('organisasi','inventarisasi.id_organisasi = organisasi.id')->where($where)->where($where_query)->get('inventarisasi')->result();
		$final = $this->fill_empty_data($final);

		foreach ($final as $key => $value) {
			$value->rincian = $this->get_rincian($value->id);
		}

		return $final;
	}

	private function get_rincian($id_inventarisasi)
	{
		$final = new StdClass();

		# Ambil aset
		$kategori = "kd_golongan, kd_bidang, kd_kelompok, kd_subkelompok, kd_subsubkelompok, k.nama";
		$where    = "WHERE id_inventarisasi = {$id_inventarisasi} AND id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL";

		$qa = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_a a JOIN kategori k ON a.id_kategori = k.id {$where}";
		$qb = "SELECT reg_induk, reg_barang, kondisi, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_b b JOIN kategori k ON b.id_kategori = k.id {$where}";
		$qc = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM temp_aset_c c JOIN kategori k ON c.id_kategori = k.id {$where}";
		$qd = "SELECT reg_induk, reg_barang, kondisi, CONCAT(null) AS merk, CONCAT('1') AS jumlah, (nilai+nilai_tambah) AS nilai, {$kategori}  FROM temp_aset_d d JOIN kategori k ON d.id_kategori = k.id {$where}";
		$qe = "SELECT reg_induk, reg_barang, kondisi, judul AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_e e JOIN kategori k ON e.id_kategori = k.id {$where}";
		$qg = "SELECT reg_induk, reg_barang, kondisi, CONCAT(merk,' ',tipe) AS merk, CONCAT('1') AS jumlah, nilai, {$kategori}  FROM temp_aset_g g JOIN kategori k ON g.id_kategori = k.id {$where}";
		
		$query = "SELECT * FROM ({$qa} UNION ALL {$qb} UNION ALL {$qc} UNION ALL {$qd} UNION ALL {$qe} UNION ALL {$qg}) AS q";
		
		$final->aset = $this->db->query($query)->result();
		$final->aset = $this->fill_empty_data($final->aset);

		# Ambil non aset
		$select = "id,nama,CONCAT(merk,' ',tipe) AS merk,nilai";
		$final->non_aset = $this->db->select($select)->where(array('id_inventarisasi'=>$id_inventarisasi))->get('aset_non')->result();
		$final->non_aset = $this->fill_empty_data($final->non_aset);

		#Ambil Kapitalisasi
		$query = $qe = "SELECT reg_induk, kap.nama_barang AS judul, CONCAT(merk,' ',tipe) AS merk, jumlah, (jumlah*nilai+nilai_penunjang) AS nilai, {$kategori}  FROM aset_kapitalisasi kap JOIN kategori k ON kap.id_kategori = k.id WHERE id_inventarisasi = {$id_inventarisasi}";
		$final->kapitalisasi = $this->db->query($query)->result();
		$final->kapitalisasi = $this->fill_empty_data($final->kapitalisasi);

		return $final;
	}

}