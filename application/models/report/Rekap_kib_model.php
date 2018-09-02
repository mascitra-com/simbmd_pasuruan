<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_kib_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_rekapitulasi($config)
	{
		$kib  = 'get_kib'.$config['kib'];
		$config['sumber_data'] = ($config['sumber_data']==1) ? '':'saldo_';
		$data = $this->{$kib}($config['id_organisasi'], $config['kd_pemilik'], $config['urut'], $config['kondisi'], $config['sumber_data']);
		return $this->fill_empty_data($data);
	}

	private function get_kiba($id, $kd_pemilik, $urut = '1', $kondisi = NULL, $sumber)
	{
		# SELECT
		$select = "ast.*,k.kd_golongan,k.kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,k.nama AS nama, o.nama AS organisasi";
		# WHERE
		if($id === '5.2' OR $id === '7.1')
		{
			$kode 	 = explode('.', $id);
			$whereId = " AND o.kd_bidang = {$kode[0]} AND o.kd_unit = {$kode[1]}";
		}
		else
		{
			$whereId = ($id !== 'all') ? "AND id_organisasi = {$id}" : '';
		}

		$where  = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik}";
		
		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}
		# ORDER
		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,reg_barang';
		# QUERY
		$query  = "SELECT {$select} FROM {$sumber}aset_a ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE {$where} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}

	private function get_kibb($id, $kd_pemilik, $urut = '1', $kondisi = NULL, $sumber)
	{
		$select = 'ast.*, k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,k.nama,o.nama AS organisasi,
		SUM(CASE WHEN (kondisi=1) THEN 1 ELSE 0 END) AS kb, SUM(CASE WHEN (kondisi=2) THEN 1 ELSE 0 END) AS kkb, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS krb,
		COUNT(ast.id) AS jumlah, SUM(nilai) AS nilai_total';

		if($id === '5.2' OR $id === '7.1') {
			$kode = explode('.', $id);
			$whereId 	  = " AND o.kd_bidang = {$kode[0]} AND o.kd_unit = {$kode[1]}";
		} else {
			$whereId = ($id !== 'all') ? "AND id_organisasi = {$id}" : '';
		}

		$where = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik}";

		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}

		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,reg_barang';
		$group  = 'tgl_perolehan,tgl_pembukuan,merk,tipe,ukuran,bahan,no_pabrik,no_rangka,no_mesin,no_polisi,no_bpkb,asal_usul,nilai,masa_manfaat,keterangan,id_kategori';
		$query  = "SELECT {$select} FROM {$sumber}aset_b ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE {$where} GROUP BY {$group} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}

	private function get_kibc($id, $kd_pemilik, $urut = '1', $kondisi = NULL, $sumber)
	{
		# SELECT
		$select = "ast.*,k.kd_golongan,k.kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,k.nama AS nama, o.nama AS organisasi";
		# WHERE
		if($id === '5.2' OR $id === '7.1')
		{
			$kode = explode('.', $id);
			$whereId = " AND o.kd_bidang = {$kode[0]} AND o.kd_unit = {$kode[1]}";
		}
		else
		{
			$whereId = ($id !== 'all') ? "AND id_organisasi = {$id}" : '';
		}

		$where = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik} AND k.kd_golongan <> 6";

		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}
		# ORDER
		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,reg_barang';
		$query  = "SELECT {$select} FROM {$sumber}aset_c ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE {$where} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}

	private function get_kibd($id, $kd_pemilik, $urut = '1', $kondisi = NULL, $sumber)
	{
		# SELECT
		$select = "ast.*,k.kd_golongan,k.kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,k.nama AS nama, o.nama AS organisasi";
		# WHERE
		if($id === '5.2' OR $id === '7.1')
		{
			$kode 	 = explode('.', $id);
			$whereId = " AND o.kd_bidang = {$kode[0]} AND o.kd_unit = {$kode[1]}";
		}
		else
		{
			$whereId = ($id !== 'all') ? "AND id_organisasi = {$id}" : '';
		}

		$where   = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik} AND k.kd_golongan <> 6";

		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}
		# ORDER
		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,reg_barang';
		$query  = "SELECT {$select} FROM {$sumber}aset_d ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE {$where} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}

	private function get_kibe($id, $kd_pemilik, $urut = '1', $kondisi = NULL, $sumber)
	{
		$select = 'ast.*, k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,k.nama,o.nama AS organisasi,
		SUM(CASE WHEN (kondisi=1) THEN 1 ELSE 0 END) AS kb, SUM(CASE WHEN (kondisi=2) THEN 1 ELSE 0 END) AS kkb, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS krb,
		COUNT(ast.id) AS jumlah, SUM(nilai) AS nilai_total';
		if($id === '5.2' OR $id === '7.1') {
			$kode = explode('.', $id);
			$whereId 	  = " AND o.kd_bidang = {$kode[0]} AND o.kd_unit = {$kode[1]}";
		} else {
			$whereId = ($id !== 'all') ? "AND id_organisasi = {$id}" : '';
		}
		$where   = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik}";

		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}

		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,reg_barang';
		$group  = 'tgl_perolehan,tgl_pembukuan,judul,pencipta,bahan,ukuran,asal_usul,nilai,masa_manfaat,keterangan,id_kategori';
		$query  = "SELECT {$select} FROM {$sumber}aset_e ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE {$where} GROUP BY {$group} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}

	private function get_kibf($id, $kd_pemilik, $urut = '1', $kondisi = NULL, $sumber)
	{
		# SELECT
		$select = 'k.*,o.nama AS organisasi,reg_barang,reg_induk,tgl_perolehan,lokasi,dokumen_tgl,dokumen_no,status_tanah,kode_tanah,kondisi,asal_usul,nilai,nilai_tambah,keterangan';
		# WHERE
		if($id === '5.2' OR $id === '7.1')
		{
			$kode 	 = explode('.', $id);
			$whereId = " AND o.kd_bidang = {$kode[0]} AND o.kd_unit = {$kode[1]}";
		}
		else
		{
			$whereId = ($id !== 'all') ? "AND id_organisasi = {$id}" : '';
		}

		$where = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik} AND k.kd_golongan = 6";

		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}
		# ORDER
		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'kd_golongan,kd_bidang,kd_kelompok,kd_subkelompok,k.kd_subsubkelompok,reg_barang';
		$queryc = "SELECT {$select},tingkat,beton,luas_lantai AS luas,CONCAT(null) AS panjang,CONCAT(null) AS lebar FROM {$sumber}aset_c ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE {$where}";
		$queryd = "SELECT {$select},panjang,lebar,luas,CONCAT(null) AS tingkat,CONCAT(null) AS beton FROM {$sumber}aset_d ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE {$where}";
		$query  = "SELECT * FROM ($queryc UNION ALL {$queryd}) AS q ORDER BY {$order}";
		return $this->db->query($query)->result();
	}

	private function get_kibg($id, $kd_pemilik, $urut = '1', $kondisi = NULL)
	{
		$select = 'ast.*, k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,k.nama,o.nama AS organisasi,
		SUM(CASE WHEN (kondisi=1) THEN 1 ELSE 0 END) AS kb, SUM(CASE WHEN (kondisi=2) THEN 1 ELSE 0 END) AS kkb, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS krb,
		COUNT(ast.id) AS jumlah, SUM(nilai) AS nilai_total';
		if($id === '5.2' OR $id === '7.1') {
			$kode = explode('.', $id);
			$whereId 	  = " AND o.kd_bidang = {$kode[0]} AND o.kd_unit = {$kode[1]}";
		} else {
			$whereId = ($id !== 'all') ? "AND id_organisasi = {$id}" : '';
		}
		$where   = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik}";

		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}

		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'k.kd_golongan,k.kd_bidang,k.kd_kelompok,k.kd_subkelompok,k.kd_subsubkelompok,reg_barang';
		$group  = 'tgl_perolehan,tgl_pembukuan,merk,tipe,ukuran,asal_usul,nilai,masa_manfaat,keterangan,id_kategori';
		$query  = "SELECT {$select} FROM {$sumber}aset_g ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON id_organisasi = o.id WHERE {$where} GROUP BY {$group} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}
}