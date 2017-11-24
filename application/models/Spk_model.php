<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Spk_model extends MY_Model
{
	public $_table = 'spk';
	public $required = array('nomor', 'tanggal', 'nilai', 'id_organisasi');

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
        $limit   = isset($filter['limit']) ? $filter['limit'] : 20;
        $ord_by  = isset($filter['ord_by']) ? $filter['ord_by'] : 'id';
        $ord_pos = isset($filter['ord_pos']) ? $filter['ord_pos'] : 'ASC';

        $this->where('id_organisasi', $filter['id_organisasi']);

        unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos'], $filter['id_organisasi']);

        $this->where('is_deleted',0);
        foreach ($filter as $key => $value)
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
}