<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kapitalisasi_model extends MY_Model_aset {

	public $_table = 'aset_kapitalisasi';
	public $requred = array('nama', 'nilai', 'jumlah', 'id_kategori', 'id_aset', 'id_spk');

	public function __construct() {
		parent::__construct();
	}
}