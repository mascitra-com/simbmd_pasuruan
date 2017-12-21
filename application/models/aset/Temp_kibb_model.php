<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Temp_kibb_model extends MY_Model
{
	public $_table = 'temp_aset_b';
	public $required = array('id_organisasi','id_kategori','ukuran','no_pabrik','no_rangka','no_mesin','no_polisi','no_bpkb','tgl_perolehan','tgl_pembukuan','asal_usul','kondisi','nilai','masa_manfaat');

    public function __construct()
    {
        parent::__construct();
    }

}