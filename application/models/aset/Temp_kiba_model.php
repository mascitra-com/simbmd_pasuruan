<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kiba_model extends MY_Model_aset
{
	public $_table = 'temp_aset_a';
    public $required = array('id_organisasi','id_kategori','nilai','tgl_pembukuan','tgl_perolehan');

    public function __construct()
    {
        parent::__construct();
    }
}