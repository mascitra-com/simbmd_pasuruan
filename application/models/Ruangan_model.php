<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Ruangan_model extends MY_Model {

	public $_table = 'ruangan';
	public $required = array('kode', 'nama', 'id_organisasi');

    public function __construct() {
        parent::__construct();
    }

    public function get_data($filter = array())
    {
        $results = array();

        # LIMIT, OFFSET, AND SORT
        $limit  = isset($filter['limit'])?$filter['limit']:'';
        $offset = isset($filter['offset'])?$filter['offset']:'';
        $sort   = isset($filter['sort'])?$filter['sort']:'';
        $order  = isset($filter['order'])?$filter['order']:'';

        # WHERE
        $where[$this->_table.'.id'] = isset($filter['id'])?$filter['id']:'';
        $where['id_organisasi']     = isset($filter['id_organisasi'])?$filter['id_organisasi']:'';

        # UNSET FILTER
        $filter = $this->unset_attr($filter);
        $where  = trim_empty_data($where);

        # SET LIKE
        if (count($filter) > 0) {
            $this->group_start();
            $this->or_like($filter);
            $this->group_end();
        }

        $this->select($this->_table.'.*, organisasi.nama AS organisasi');
        $this->join('organisasi', 'organisasi.id = id_organisasi');

        # SET LIMIT AND OFFSET
        if (!empty($limit) OR !empty($offset)) {
            $clone = clone($this->db);
            $results['total'] = $clone->where($where)->from($this->_table)->count_all_results();

            $this->limit($limit, $offset);
        }

        # SET SORT
        if (!empty($sort)) {
            $this->order_by($sort, $order);
        }

        $results['rows'] = $this->subtitute( $this->get_many_by($where) );
        return $results;
    }

    private function unset_attr($filter = array())
    {
        unset($filter['limit'],$filter['offset'], $filter['order'], $filter['sort']);
        unset($filter['id'], $filter['id_organisasi']);
        unset($filter['search']);
        return $filter;
    }

    public function get_formated_data()
    {
    	$result = $this->get_all();
    	$final  = array();

    	foreach ($result as $key => $value) {
    		$final[$value->id] = $value->nama;
    	}

    	return $final;
    }
}