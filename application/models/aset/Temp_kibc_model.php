<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kibc_model extends MY_Model
{
	public $_table = 'temp_aset_c';
    public $required = array('id_organisasi','id_kategori','nilai','tgl_pembukuan','tgl_perolehan','kondisi','nilai');

    public function __construct()
    {
        parent::__construct();
    }

}