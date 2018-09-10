<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model_aset extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function get_data_aset($filter = array())
	{
		$results = array();

      # LIMIT, OFFSET, AND SORT
		$limit  = isset($filter['limit'])?$filter['limit']:'';
		$offset = isset($filter['offset'])?$filter['offset']:'';
		$sort   = isset($filter['sort'])?$filter['sort']:'';
		$order  = isset($filter['order'])?$filter['order']:'';

      # WHERE ID etc.
		$where['id']            = isset($filter['id'])?$filter['id']:'';
		$where['id_organisasi'] = isset($filter['id_organisasi'])?$filter['id_organisasi']:'';
		$where['id_kategori']   = isset($filter['id_kategori'])?$filter['id_kategori']:'';
		$where['id_spk']        = isset($filter['id_spk'])?$filter['id_spk']:'';
		$where['id_hibah']      = isset($filter['id_hibah'])?$filter['id_hibah']:'';
		$where['id_invent']     = isset($filter['id_inventarisasi'])?$filter['id_inventarisasi']:'';

		# EXCLUDE
		$excludes = isset($filter['excludes'])?$filter['excludes']:array();
		$is_kdp   = isset($filter['is_kdp'])?$filter['is_kdp']: FALSE;

		# UNSET FILTER
		$filter = $this->unset_attr($filter);

      # SET WHERE ARRAY
		$where 	 = $this->set_where($where);
		$excludes = $this->set_where($excludes);

		# SET LIKE
		if (count($filter) > 0) {
			$this->group_start();
			$this->or_like($filter);
			$this->group_end();
		}

		# SET WHERE NOT IN
		if (count($excludes) > 0) {
			foreach ($excludes as $key => $value) {
				$this->where_not_in($key, $value);
			}
		}

		# SET KDP
		$this->select($this->_table.'.*');
		$this->join('kategori', 'kategori.id = id_kategori');
		
		if ($is_kdp) {
			$this->where('kd_golongan', 6);
		}else{
			$this->where('kd_golongan<>', 6);
		}

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

	private function unset_attr($data)
	{
		unset($data['limit'],$data['offset'], $data['order'], $data['sort']);
		unset($data['id'],$data['id_organisasi'],$data['id_kategori']);
		unset($data['id_spk'],$data['id_hibah'],$data['id_inventarisasi']);
		unset($data['excludes'], $data['search'], $data['is_kdp']);
		return $data;
	}

	private function set_where($data)
	{
		foreach ($data as $key => $value) {
			if (empty($value)) {
				unset($data[$key]);
			}
		}
		return $data;
	}
}