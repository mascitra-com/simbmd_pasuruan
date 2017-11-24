<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Sp2d_model extends MY_Model
{
	public $_table = 'sp2d';
	public $required = array('nomor', 'tanggal', 'nilai', 'id_spk');

    public function __construct()
    {
        parent::__construct();
    }

    public function total($data)
    {
    	$total = 0;
    	
    	foreach ($data as $dat) {
    		$total += $dat->nilai;
    	}
    	return $total;
    }
}