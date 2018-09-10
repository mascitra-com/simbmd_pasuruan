<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Organisasi_model extends MY_Model {

	public $_table = 'organisasi';
	public $requred = array('kode', 'nama', 'sub_dari');

	public function __construct() {
		parent::__construct();
	}

	public function get_data($where = array())
    {
        $this->where($where);
        $this->order_by('kd_bidang')
        ->order_by('kd_unit')
        ->order_by('kd_subunit')
        ->order_by('kd_upb');

        $result = $this->get_all();

        foreach ($result as $key => $value) {
            $value->kode  = !empty($value->kd_bidang) ? zerofy($value->kd_bidang) : '';
            $value->kode .= !empty($value->kd_unit) ? '.'.(zerofy($value->kd_unit)) : '';
            $value->kode .= !empty($value->kd_subunit) ? '.'.(zerofy($value->kd_subunit)) : '';
            $value->kode .= !empty($value->kd_upb) ? '.'.(zerofy($value->kd_upb)) : '';
        }

        $result = $this->fill_empty_data($result);
        return $result;
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

    public function get_id_by_auth($id_organisasi)
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
}