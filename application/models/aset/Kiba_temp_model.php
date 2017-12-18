<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kiba_temp_model extends MY_Model
{
	public $_table = 'aset_a_temp';
	public $required = array('id_organisasi','id_kategori','nilai','sertifikat_tgl','sertifikat_no','pengguna','tahun','alamat','hak','tgl_pembukuan','tgl_perolehan','luas','asal_usul');

    public function __construct()
    {
        parent::__construct();
    }
}