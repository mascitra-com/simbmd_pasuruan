<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kibc_model extends MY_Model
{
	public $_table = 'temp_aset_c';
	public $required = array('id_organisasi','id_kategori','nilai','tingkat','beton','luas_lantai','dokumen_tgl','status_tanah','tgl_pembukuan','tgl_perolehan','asal_usul','kondisi','nilai','kategori');

    public function __construct()
    {
        parent::__construct();
    }

}