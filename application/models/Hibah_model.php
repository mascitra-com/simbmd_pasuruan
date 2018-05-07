<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Hibah_model extends MY_Model
{
	public $_table = 'hibah';
	public $required = array('tgl_jurnal', 'asal_penerimaan', 'id_organisasi');

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

    public function get_total_rincian($id_hibah = NULL)
    {
        if (empty($id_hibah)) {
            return 0;
        }

        $qa = "SELECT SUM(nilai) AS nilai FROM temp_aset_a WHERE id_hibah = {$id_hibah} AND id_hibah IS NULL AND id_koreksi IS NULL";
        $qb = "SELECT SUM(nilai) AS nilai FROM temp_aset_b WHERE id_hibah = {$id_hibah} AND id_hibah IS NULL AND id_koreksi IS NULL";
        $qc = "SELECT SUM(nilai) AS nilai FROM temp_aset_c WHERE id_hibah = {$id_hibah} AND id_hibah IS NULL AND id_koreksi IS NULL";
        $qd = "SELECT SUM(nilai) AS nilai FROM temp_aset_d WHERE id_hibah = {$id_hibah} AND id_hibah IS NULL AND id_koreksi IS NULL";
        $qe = "SELECT SUM(nilai) AS nilai FROM temp_aset_e WHERE id_hibah = {$id_hibah} AND id_hibah IS NULL AND id_koreksi IS NULL";
        $qg = "SELECT SUM(nilai) AS nilai FROM temp_aset_g WHERE id_hibah = {$id_hibah} AND id_hibah IS NULL AND id_koreksi IS NULL";
        $qk = "SELECT SUM(nilai + nilai_penunjang) AS nilai FROM aset_kapitalisasi WHERE id_hibah = {$id_hibah}";
        $qnon = "SELECT SUM(nilai) AS nilai FROM aset_non WHERE id_hibah = {$id_hibah}";

        $query = "SELECT SUM(nilai) AS nilai FROM({$qa} UNION ALL {$qb} UNION ALL {$qc} UNION ALL {$qd} UNION ALL {$qe} UNION ALL {$qg} UNION ALL {$qk} UNION ALL {$qnon}) AS q";
        return $this->db->query($query)->result()[0]->nilai;
    }
}