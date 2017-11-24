<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Pegawai_model extends MY_Model
{

	public $_table = 'user';
	public $requred = array('nama', 'username', 'password', 'password_re', 'id_organisasi');
	protected $has_many = array('kategori');

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Auth_model', 'auth');
	}

	public function get_data($filter = array())
	{
		# Prepare separate filter
		$result  = array();
		$page    = isset($filter['page']) ? $filter['page'] : 1;
		$limit	 = isset($filter['limit']) ? $filter['limit'] : 200;
		$ord_by	 = isset($filter['ord_by']) ? $filter['ord_by'] : 'id';
		$ord_pos = isset($filter['ord_pos']) ? $filter['ord_pos'] : 'ASC';

		# Unset non-filter data
		unset($filter['page'], $filter['limit'], $filter['ord_by'], $filter['ord_pos']);

    	# Begin filter
    	$this->where('id<>', $this->auth->get_id());
    	# If not a super admin
    	if (!$this->auth->get_super_access()) {
    		$this->where('id_organisasi', $this->auth->get_id_organisasi());
    	}

		foreach ($filter as $key => $value)
			$this->like($key, $value);

    	# Get result count for pagination
		$tmp = clone $this->db;
		$result["data_count"] = $tmp->from("{$this->_table}")->count_all_results();

		# Limit & order
		$this->order_by($ord_by, $ord_pos);
		$this->limit($limit, ($page - 1) * $limit);

		# Return result
		$this->empty_substitution = "<span class='text-secondary'><i>(kosong)</i></span>";
		$result['data'] = $this->fill_empty_data($this->get_all());

		# convert organisasi_id to nama
		$formated = $this->organisasi->get_formated_data();
		foreach ($result['data'] as $peg) {
			$peg->id_organisasi = $formated[$peg->id_organisasi];
		}

		return $result;
	}
}