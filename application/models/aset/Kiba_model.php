<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kiba_model extends MY_Model_aset
{
	public $_table = 'aset_a';
	public $required = array('id_organisasi','id_kategori','nilai','tgl_pembukuan','tgl_perolehan');
    public $_kolom = array('reg_barang','reg_induk','luas','alamat','sertifikat_tgl','sertifikat_no','hak','pengguna','tgl_perolehan','tgl_pembukuan','asal_usul','kondisi','nilai','keterangan');

    public function __construct()
    {
        parent::__construct();
    }

    public function get_data($filter = array())
    {
    	if (!isset($filter['id_organisasi']) OR empty($filter['id_organisasi']))
    	{
    		return array('data'=>array(), 'data_count'=>0);
    	}

    	$result  = array();
		$page    = isset($filter['page']) ? $filter['page'] : 1;
		$limit	 = isset($filter['limit']) ? $filter['limit'] : 20;
		$ord_by	 = isset($filter['ord_by']) ? $filter['ord_by'] : 'id';
		$ord_pos = isset($filter['ord_pos']) ? $filter['ord_pos'] : 'ASC';

        $this->where('id_organisasi', $filter['id_organisasi']);

		unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos'], $filter['id_organisasi']);

		$this->where('is_deleted',0);
		foreach (trim_empty_data($filter) as $key => $value)
			$this->like($key, $value);

    	# Get result count for pagination
		$tmp = clone $this->db;
		$result["data_count"] = $tmp->from("{$this->_table}")->count_all_results();

		# Limit & order
		$this->order_by($ord_by, $ord_pos);
		$this->limit($limit, ($page - 1) * $limit);

		# Return result
		;
        $result['data'] = $this->subtitute($this->get_all());
		$result['data'] = $this->fill_empty_data($result['data']);

		return $result;
    }

    public function get_rincian_widget($id_organisasi)
    {
        $query = "SELECT COUNT(a.id) AS total, SUM(CASE WHEN (kondisi=3) THEN 1 ELSE 0 END) AS total_rusak, SUM(nilai) AS nilai, SUM(CASE WHEN(kondisi=3) THEN nilai ELSE 0 END) AS nilai_rusak
        FROM {$this->_table} a JOIN kategori k ON a.id_kategori = k.id 
        WHERE id_organisasi = {$id_organisasi} AND kd_golongan <> 6";
        return $this->db->query($query)->result()[0];
    }
}