<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Profil_model extends MY_Model {

	public $_table = 'user';
	public $requred = array('nama', 'username');

	public function __construct() {
		parent::__construct();
	}
}