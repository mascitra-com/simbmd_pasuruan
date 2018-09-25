<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Organisasi_model extends MY_Model {

	public $_table = 'organisasi';
	public $requred = array('kode', 'nama', 'sub_dari');

	public function __construct() {
		parent::__construct();
	}

	public function get_data($filter = array())
    {
        # LIMIT, OFFSET, AND SORT
        $limit  = isset($filter['limit'])?$filter['limit']:'';
        $offset = isset($filter['offset'])?$filter['offset']:'';
        $sort   = isset($filter['sort'])?$filter['sort']:'';
        $order  = isset($filter['order'])?$filter['order']:'';

        # WHERE
        $where[$this->_table.'.id'] = isset($filter['id'])?$filter['id']:'';
        $where['kd_bidang']  = isset($filter['kd_bidang'])?$filter['kd_bidang']:'';
        $where['kd_unit']    = isset($filter['kd_unit'])?$filter['kd_unit']:'';
        $where['kd_subunit'] = isset($filter['kd_subunit'])?$filter['kd_subunit']:'';
        $where['kd_upb']     = isset($filter['kd_upb'])?$filter['kd_upb']:'';
        $where['sub_dari']   = isset($filter['sub_dari'])?$filter['sub_dari']:'';
        $where['jenis']      = isset($filter['jenis'])?$filter['jenis']:'';

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
            $this->order_by('kd_bidang')->order_by('kd_unit')->order_by('kd_subunit')->order_by('kd_upb');
        }

        $results['rows'] = $this->subtitute( $this->get_many_by($where) );

        foreach ($results['rows'] as $key => $value) {
            $value->kode  = !empty($value->kd_bidang) ? zerofy($value->kd_bidang) : '';
            $value->kode .= !empty($value->kd_unit) ? '.'.(zerofy($value->kd_unit)) : '';
            $value->kode .= !empty($value->kd_subunit) ? '.'.(zerofy($value->kd_subunit)) : '';
            $value->kode .= !empty($value->kd_upb) ? '.'.(zerofy($value->kd_upb)) : '';
        }

        return $results;
    }

    private function unset_attr($filter)
    {
        unset($filter['limit'],$filter['offset'], $filter['order'], $filter['sort']);
        unset($filter['id'], $filter['sub_dari'], $filter['jenis']);
        unset($filter['kd_bidang'], $filter['kd_unit'], $filter['kd_subunit'], $filter['kd_upb']);
        unset($filter['search']);
        return trim_empty_data($filter);
    }

    public function get_data_by_auth()
    {
        $this->load->model('Auth_model', 'auth');
        $result = $this->get_many_by(array('jenis'=>4));
        
        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
           $id = $this->auth->get_id_organisasi();

            # Jika kepala UPB
            if ($this->auth->get_kepala_access()) {
                $temp   = $this->get($id);
                $result = $this->get_many_by(array('kd_bidang'=>$temp->kd_bidang, 'kd_unit'=>$temp->kd_unit, 'jenis'=>4));
            } else {
                $result = $this->get_many_by('id', $id);
            }
        }

        return $result;
    }

    public function get_id_by_auth($id_organisasi = '')
    {
        $this->load->model('Auth_model', 'auth');
        return (!$this->auth->get_super_access()) ? $this->auth->get_id_organisasi() : $id_organisasi;
    }

    public function get_org_induk($kode)
    {
        $kode = explode('.', $kode);
        $this->db->where('kd_bidang', $kode[0]);
        $this->db->where('kd_unit', $kode[1]);
        $this->db->where('jenis', '2');
        return $this->db->get('organisasi')->row();
    }

    public function lebur($id_asal, $id_tujuan)
    {
        $table = array('aset_a','aset_b','aset_c','aset_d','aset_e','aset_g','aset_kapitalisasi','aset_non','temp_aset_a','temp_aset_b','temp_aset_c','temp_aset_d','temp_aset_e','temp_aset_g','saldo_aset_a','saldo_aset_b','saldo_aset_c','saldo_aset_d','saldo_aset_e','saldo_aset_g','inventarisasi','spk','hibah','transfer','penghapusan','koreksi','kegiatan','user','pelunasan','ruangan');
        foreach ($table as $tbl) {
            $query = "UPDATE {$tbl} SET id_organisasi = {$id_tujuan} WHERE id_organisasi = {$id_asal}";
            $this->db->query($query);
        }
    }
}