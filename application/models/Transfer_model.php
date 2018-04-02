<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Transfer_model extends MY_Model
{
	public $_table = 'transfer';
	public $required = array('id_tujuan', 'id_organisasi');

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
		$this->empty_substitution = "<span class='text-secondary'><i>kosong</i></span>";
        $result['data'] = $this->subtitute($this->get_all());
		$result['data'] = $this->fill_empty_data($result['data']);

		return $result;
    }

    public function get_data_masuk($filter = array())
    {
    	if (!isset($filter['id_tujuan']) OR empty($filter['id_tujuan']))
    	{
    		return array('data'=>array(), 'data_count'=>0);
    	}

    	$result  = array();
		$page    = isset($filter['page']) ? $filter['page'] : 1;
		$limit	 = isset($filter['limit']) ? $filter['limit'] : 20;
		$ord_by	 = isset($filter['ord_by']) ? $filter['ord_by'] : 'id';
		$ord_pos = isset($filter['ord_pos']) ? $filter['ord_pos'] : 'ASC';

        $this->where('id_tujuan', $filter['id_tujuan']);

		unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos'], $filter['id_tujuan']);

		$this->where('is_deleted', 0)->where('status_pengajuan', 2);
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

    public function get_data_persetujuan($filter = array())
    {
    	$result  = array();
		$page    = isset($filter['page']) ? $filter['page'] : 1;
		$limit	 = isset($filter['limit']) ? $filter['limit'] : 20;
		$ord_by	 = isset($filter['ord_by']) ? $filter['ord_by'] : 'id';
		$ord_pos = isset($filter['ord_pos']) ? $filter['ord_pos'] : 'ASC';

		unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos'], $filter['id_tujuan']);

		$this->where('is_deleted', 0)->where('status_pengajuan', 1);
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

    public function get_total_rincian($id_transfer = NULL)
    {
        if (empty($id_transfer)) {
            return 0;
        }

        $qa = "SELECT SUM(nilai) AS nilai FROM temp_aset_a WHERE id_transfer = {$id_transfer}";
        $qb = "SELECT SUM(nilai) AS nilai FROM temp_aset_b WHERE id_transfer = {$id_transfer}";
        $qc = "SELECT SUM(nilai) AS nilai FROM temp_aset_c WHERE id_transfer = {$id_transfer}";
        $qd = "SELECT SUM(nilai) AS nilai FROM temp_aset_d WHERE id_transfer = {$id_transfer}";
        $qe = "SELECT SUM(nilai) AS nilai FROM temp_aset_e WHERE id_transfer = {$id_transfer}";
        $qg = "SELECT SUM(nilai) AS nilai FROM temp_aset_g WHERE id_transfer = {$id_transfer}";

        $query = "SELECT SUM(nilai) AS nilai FROM({$qa} UNION {$qb} UNION {$qc} UNION {$qd} UNION {$qe} UNION {$qg}) AS q";
        return $this->db->query($query)->result()[0]->nilai;
    }
}