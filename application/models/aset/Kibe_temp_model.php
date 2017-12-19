<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kibe_temp_model extends MY_Model
{
	public $_table = 'aset_e_temp';
	public $required = array('id_organisasi','id_kategori','nilai','nilai_sisa','judul','pencipta','ukuran','tgl_perolehan','tgl_pembukuan','asal_usul','kondisi','kategori');

    public function __construct()
    {
        parent::__construct();
    }

}