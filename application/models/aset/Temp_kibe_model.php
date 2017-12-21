<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kibe_model extends MY_Model
{
	public $_table = 'temp_aset_e';
	public $required = array('id_organisasi','id_kategori','nilai','nilai_sisa','judul','pencipta','ukuran','tgl_perolehan','tgl_pembukuan','asal_usul','kondisi','kategori');

    public function __construct()
    {
        parent::__construct();
    }

}