<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_ekstrakomtabel_model extends MY_Model {

	public $priode;

	public function __construct() {
		parent::__construct();
		$this->periode = $this->setting->get('periode_start');
	}

	public function get_rekapitulasi($config)
	{
		$kib  = 'get_kib'.$config['kib'];
		$data = $this->{$kib}($config['id_organisasi'], $config['kd_pemilik'], $config['urut'], $config['kondisi']);
		return $this->fill_empty_data($data);
	}

	private function get_kibb($id, $kd_pemilik, $urut = '1', $kondisi = NULL)
	{
		$select = 'ast.*, k.kd_golongan,k.kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,k.nama,o.nama AS organisasi,
		SUM(CASE WHEN (kondisi=1) THEN 1 ELSE 0 END) AS kb, SUM(CASE WHEN (kondisi=2) THEN 1 ELSE 0 END) AS kkb, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS krb,
		COUNT(ast.id) AS jumlah, SUM(nilai) AS nilai_total';
		
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

		$where = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik} AND nilai < batas_nilai AND YEAR(tgl_perolehan) >= {$this->periode}";
		
		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}

		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'k.kd_golongan,k.kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,reg_barang';
		$group  = 'tgl_perolehan,tgl_pembukuan,merk,tipe,ukuran,bahan,no_pabrik,no_rangka,no_mesin,no_polisi,no_bpkb,asal_usul,nilai,masa_manfaat,keterangan,id_kategori';
		$query  = "SELECT {$select} FROM aset_b ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON ast.id_organisasi = o.id WHERE {$where} GROUP BY {$group} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}

	private function get_kibc($id, $kd_pemilik, $urut = '1', $kondisi = NULL)
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

		$where  = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik} AND kd_golongan <> 6 AND nilai < batas_nilai AND YEAR(tgl_perolehan) >= {$this->periode}";
		
		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}

		$order  = "id_organisasi,";
		$order .= ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'kd_golongan,kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,reg_barang';
		$query  = "SELECT {$select} FROM aset_c ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON ast.id_organisasi = o.id WHERE {$where} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}

	private function get_kibe($id, $kd_pemilik, $urut = '1', $kondisi = NULL)
	{
		$select = 'ast.*, kd_golongan,kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,k.nama,o.nama AS organisasi,
		SUM(CASE WHEN (kondisi=1) THEN 1 ELSE 0 END) AS kb, SUM(CASE WHEN (kondisi=2) THEN 1 ELSE 0 END) AS kkb, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS krb,
		COUNT(ast.id) AS jumlah, SUM(nilai) AS nilai_total';
		
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

		$where  = "ast.is_deleted = 0 {$whereId} AND kd_pemilik = {$kd_pemilik} AND nilai < batas_nilai AND YEAR(tgl_perolehan) >= {$this->periode}";
		
		if(!empty($kondisi)){
			$where .= " AND kondisi =".$kondisi;
		}
		
		$order  = "id_organisasi,";
		$order  = ($urut==='2') ? 'YEAR(tgl_perolehan),' : '';
		$order .= 'kd_golongan,kd_bidang,kd_kelompok,kd_subkelompok,kd_subsubkelompok,reg_barang';
		$group  = 'tgl_perolehan,tgl_pembukuan,judul,pencipta,bahan,ukuran,asal_usul,nilai,masa_manfaat,keterangan,id_kategori';
		$query  = "SELECT {$select} FROM aset_e ast JOIN kategori k ON ast.id_kategori = k.id JOIN organisasi o ON ast.id_organisasi = o.id WHERE {$where} GROUP BY {$group} ORDER BY {$order}";
		return $this->db->query($query)->result();
	}
}