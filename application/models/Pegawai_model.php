<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Pegawai_model extends MY_Model
{

    public $_table = 'user';
    public $requred = array('nama', 'username', 'password', 'password_re', 'id_organisasi');
    protected $has_many = array('kategori');

    public function __construct()
    {
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
        $where['kd_bidang']  = isset($filter['kd_bidang'])?$filter['kd_bidang']:'';
        $where['kd_unit']    = isset($filter['kd_unit'])?$filter['kd_unit']:'';
        $where['kd_subunit'] = isset($filter['kd_subunit'])?$filter['kd_subunit']:'';
        $where['kd_upb']     = isset($filter['kd_upb'])?$filter['kd_upb']:'';

        # UNSET FILTER
        $filter = $this->unset_attr($filter);
        $where  = trim_empty_data($where);

        # SET LIKE
        if (count($filter) > 0) {
            $this->group_start();
            $this->or_like($filter);
            $this->group_end();
        }

        $this->select($this->_table.'.*');
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
        unset($filter['kd_bidang'], $filter['kd_unit'], $filter['kd_subunit'], $filter['kd_upb']);
        unset($filter['search']);
        return $filter;
    }
}