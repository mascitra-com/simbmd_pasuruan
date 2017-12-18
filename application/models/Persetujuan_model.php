<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Persetujuan_model extends MY_Model {

	public $_table = 'persetujuan';
	public $requred = array('status', 'id_aksi', 'jenis_aksi');

	public function __construct() {
		parent::__construct();
	}
}