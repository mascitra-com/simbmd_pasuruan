<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kibd_model extends MY_Model
{
	public $_table = 'temp_aset_d';
    public $required = array('id_organisasi','id_kategori','tgl_perolehan','tgl_pembukuan','kondisi','nilai');

    public function __construct()
    {
        parent::__construct();
    }

}