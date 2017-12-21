<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kiba_model extends MY_Model
{
	public $_table = 'temp_aset_a';
	public $required = array('id_organisasi','id_kategori','nilai','sertifikat_tgl','sertifikat_no','pengguna','tahun','alamat','hak','tgl_pembukuan','tgl_perolehan','luas','asal_usul');

    public function __construct()
    {
        parent::__construct();
    }
}