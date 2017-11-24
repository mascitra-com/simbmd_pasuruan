<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kategori_model extends MY_Model
{
	public $_table = 'kategori';
	public $required = array('kode', 'nama');

    public function __construct()
    {
        parent::__construct();
    }

    public function get_data_list($where = array())
    {
        $this->where($where);
        $this->order_by('kd_golongan')
        ->order_by('kd_bidang')
        ->order_by('kd_kelompok')
        ->order_by('kd_subkelompok')
        ->order_by('kd_subsubkelompok');

        $result = $this->get_all();

        foreach ($result as $key => $value) {
            $value->kode  = !empty($value->kd_golongan) ? $value->kd_golongan : '';
            $value->kode .= !empty($value->kd_bidang) ? '.'.($value->kd_bidang) : '';
            $value->kode .= !empty($value->kd_kelompok) ? '.'.($value->kd_kelompok) : '';
            $value->kode .= !empty($value->kd_subkelompok) ? '.'.($value->kd_subkelompok) : '';
            $value->kode .= !empty($value->kd_subsubkelompok) ? '.'.($value->kd_subsubkelompok) : '';
        }

        return $result;
    }

    public function get_formated_data()
    {
    	$result = $this->get_all();
    	$final  = array();

    	foreach ($result as $key => $value) {
    		$final[$value->id] = $value;
    	}

    	return $final;
    }

    public function get_formated_data_by_kode()
    {
        $result = $this->get_data_list(array('jenis'=>5));
        $final  = array();

        foreach ($result as $key => $value) {
            $final[$value->kode] = $value->id;
        }

        return $final;
    }
}