<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Koreksi_model extends MY_Model {

	public $_table = 'koreksi';
	public $requred = array('tgl_jurnal', 'id_organisasi');

	public function __construct() {
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

    public function get_data_rincian($id_koreksi=NULL)
    {
    	if(empty($id_koreksi))
    		return array();

    	$this->load->model('aset/Temp_kiba_model', 'kiba');
    	$this->load->model('aset/Temp_kibb_model', 'kibb');
    	$this->load->model('aset/Temp_kibc_model', 'kibc');
    	$this->load->model('aset/Temp_kibd_model', 'kibd');
    	$this->load->model('aset/Temp_kibe_model', 'kibe');

    	$data['kiba'] = $this->kiba->select('temp_aset_a.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_a.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
    	$data['kibb'] = $this->kibb->select('temp_aset_b.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_b.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
    	$data['kibc'] = $this->kibc->select('temp_aset_c.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_c.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
    	$data['kibd'] = $this->kibd->select('temp_aset_d.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_d.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
    	$data['kibe'] = $this->kibe->select('temp_aset_e.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_e.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);

        foreach ($data as $key => $value) {
            $empty_value = "-";
            $value = $this->fill_empty_data($this->subtitute($value), $empty_value);
        }
    
    	return $data;
    }

    public function get_data_persetujuan($filter = array())
    {
        $result  = array();
        $page    = isset($filter['page']) ? $filter['page'] : 1;
        $limit   = isset($filter['limit']) ? $filter['limit'] : 20;
        $ord_by  = isset($filter['ord_by']) ? $filter['ord_by'] : 'id';
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
}