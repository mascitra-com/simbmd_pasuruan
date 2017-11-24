<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Ruangan_model extends MY_Model {

	public $_table = 'ruangan';
	public $required = array('kode', 'nama', 'id_organisasi');

    public function __construct() {
        parent::__construct();
    }

    public function get_formated_data()
    {
    	$result = $this->get_all();
    	$final  = array();

    	foreach ($result as $key => $value) {
    		$final[$value->id] = $value->nama;
    	}

    	return $final;
    }
}