<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kibg_model extends MY_Model
{
	public $_table = 'temp_aset_g';
    public $required = array('id_organisasi','id_kategori','nilai','tgl_perolehan','tgl_pembukuan');

    public function __construct()
    {
        parent::__construct();
    }

}