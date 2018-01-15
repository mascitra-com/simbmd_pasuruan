<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Koreksi_detail_model extends MY_Model {

	public $_table = 'koreksi_detail';
	public $requred = array('id_aset_temp', 'original_value', 'corrected_value');

	public function __construct() {
		parent::__construct();
	}
}