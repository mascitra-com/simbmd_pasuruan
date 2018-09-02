<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kibd_model extends MY_Model
{
	public $_table = 'aset_d';
	public $required = array('id_organisasi','id_kategori','tgl_perolehan','tgl_pembukuan','kondisi','nilai');

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

        $this->join('kategori', $this->_table.'.id_kategori = kategori.id');
        $this->select("{$this->_table}.*");
        $this->where('id_organisasi', $filter['id_organisasi']);

        if ($filter['is_kdp']) {
            $this->where('kd_golongan', '6');
        } else {
            $this->where('kd_golongan<>', '6');
        }

		unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos'], $filter['id_organisasi'], $filter['is_kdp']);

		$this->where("{$this->_table}.is_deleted",0);
		foreach (trim_empty_data($filter) as $key => $value)
			$this->like($key, $value);

    	# Get result count for pagination
		$tmp = clone $this->db;
		$result["data_count"] = $tmp->from("{$this->_table}")->count_all_results();

		# Limit & order
		$this->order_by($ord_by, $ord_pos);
		$this->limit($limit, ($page - 1) * $limit);

		# Return result
		$this->empty_substitution = "<span class='text-secondary'><i>kosong</i></span>";
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