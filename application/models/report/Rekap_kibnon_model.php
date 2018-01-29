<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Rekap_kibnon_model extends MY_Model {

	public function __construct() 
	{
		parent::__construct();
	}

	public function get_rekapitulasi($id_organisasi)
	{
		$query = "SELECT aset_non.*, COUNT(aset_non.id) AS jumlah_barang, SUM(aset_non.nilai) AS jumlah_nilai, tgl_serah_terima FROM aset_non
		JOIN spk ON aset_non.id_spk = spk.id WHERE aset_non.id_organisasi = {$id_organisasi}
		GROUP BY nama, merk, tipe, keterangan, aset_non.nilai";
		$data = $this->db->query($query)->result();
		return $this->fill_empty_data($data);
	}
}