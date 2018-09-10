<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kibe_model extends MY_Model_aset
{
	public $_table = 'temp_aset_e';
    public $required = array('id_organisasi','id_kategori','nilai','tgl_perolehan','tgl_pembukuan','kondisi');

    public function __construct()
    {
        parent::__construct();
    }

}