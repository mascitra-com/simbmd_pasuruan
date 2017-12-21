<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kibd_model extends MY_Model
{
	public $_table = 'temp_aset_d';
	public $required = array('id_organisasi','id_kategori','panjang','lebar','luas','lokasi','dokumen_tgl','dokumen_no','status_tanah','kode_tanah','tgl_perolehan','tgl_pembukuan','asal_usul','kondisi','nilai','kategori');

    public function __construct()
    {
        parent::__construct();
    }

}