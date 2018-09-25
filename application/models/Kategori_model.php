<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Kategori_model extends MY_Model
{
	public $_table = 'kategori';
	public $required = array('kode', 'nama');

    public function __construct()
    {
        parent::__construct();
    }

    public function get_data_list($filter = array())
    {
        # LIMIT, OFFSET, AND SORT
        $limit  = isset($filter['limit'])?$filter['limit']:'';
        $offset = isset($filter['offset'])?$filter['offset']:'';
        $sort   = isset($filter['sort'])?$filter['sort']:'';
        $order  = isset($filter['order'])?$filter['order']:'';

        # WHERE
        $where[$this->_table.'.id'] = isset($filter['id'])?$filter['id']:'';
        $where['kd_golongan']       = isset($filter['kd_golongan'])?$filter['kd_golongan']:'';
        $where['kd_bidang']         = isset($filter['kd_bidang'])?$filter['kd_bidang']:'';
        $where['kd_kelompok']       = isset($filter['kd_kelompok'])?$filter['kd_kelompok']:'';
        $where['kd_subkelompok']    = isset($filter['kd_subkelompok'])?$filter['kd_subkelompok']:'';
        $where['kd_subsubkelompok'] = isset($filter['kd_subsubkelompok'])?$filter['kd_subsubkelompok']:'';
        $where['sub_dari'] = isset($filter['sub_dari'])?$filter['sub_dari']:'';
        $where['jenis']    = isset($filter['jenis'])?$filter['jenis']:'';

        # UNSET FILTER
        $filter = $this->unset_attr($filter);
        $where  = trim_empty_data($where);

        # SET LIKE
        if (count($filter) > 0) {
            $this->group_start();
            $this->or_like($filter);
            $this->group_end();
        }

        if (!empty($limit) OR !empty($offset)) {
            $clone = clone($this->db);
            $results['total'] = $clone->where($where)->from($this->_table)->count_all_results();

            $this->limit($limit, $offset);
        }

        # SET SORT
        if (!empty($sort)) {
            $this->order_by($sort, $order);
        }else{
            $this->order_by('kd_golongan')->order_by('kd_bidang')->order_by('kd_kelompok')
            ->order_by('kd_subkelompok')->order_by('kd_subsubkelompok');
        }

        $results['rows'] = $this->subtitute( $this->get_many_by($where) );

        foreach ($results['rows'] as $key => $value) {
            $value->kode  = !empty($value->kd_golongan) ? zerofy($value->kd_golongan) : '';
            $value->kode .= !empty($value->kd_bidang) ? '.'.(zerofy($value->kd_bidang)) : '';
            $value->kode .= !empty($value->kd_kelompok) ? '.'.(zerofy($value->kd_kelompok)) : '';
            $value->kode .= !empty($value->kd_subkelompok) ? '.'.(zerofy($value->kd_subkelompok)) : '';
            $value->kode .= !empty($value->kd_subsubkelompok) ? '.'.(zerofy($value->kd_subsubkelompok)) : '';
        }

        return isset($results['total'])?$results:$results['rows'];
    }

    private function unset_attr($filter)
    {
        unset($filter['limit'],$filter['offset'], $filter['order'], $filter['sort']);
        unset($filter['id'], $filter['sub_dari'], $filter['jenis']);
        unset($filter['kd_golongan'], $filter['kd_bidang'], $filter['kd_kelompok'], $filter['kd_subkelompok'], $filter['kd_subsubkelompok']);
        unset($filter['search']);
        return trim_empty_data($filter);
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