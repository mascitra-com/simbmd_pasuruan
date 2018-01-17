<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_ruangan_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_rekapitulasi($id_ruangan)
	{
        $select = 'ast.id, ast.kd_pemilik, o.kd_unit, kd_subunit, kd_upb, ast.tgl_perolehan, ast.reg_barang, ast.tipe, ast.merk, ast.ukuran, ast.id_ruangan, ast.keterangan, kd_golongan,k.kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,k.nama,
		SUM(CASE WHEN (kondisi=1) THEN 1 ELSE 0 END) AS kb, SUM(CASE WHEN (kondisi=2) THEN 1 ELSE 0 END) AS kkb, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS krb,
		COUNT(ast.id) AS jumlah, SUM(nilai) AS nilai_total';
		$where  = "ast.is_deleted = 0 AND id_ruangan = {$id_ruangan}";
        $group  = 'tgl_perolehan,merk,tipe,ukuran,keterangan,id_kategori';
        $query  = "SELECT {$select} FROM aset_b ast JOIN kategori k ON ast.id_kategori = k.id  JOIN organisasi o ON ast.id_organisasi = o.id WHERE {$where} GROUP BY {$group}";
		return $this->db->query($query)->result();
	}
}