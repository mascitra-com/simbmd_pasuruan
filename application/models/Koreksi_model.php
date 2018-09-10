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
        ;
        $result['data'] = $this->subtitute($this->get_all());
        $result['data'] = $this->fill_empty_data($result['data']);

        return $result;
    }

    public function get_data_rincian($id_koreksi=NULL)
    {
        if(empty($id_koreksi))
            return array();

        $koreksi = $this->get($id_koreksi);

        if ($koreksi->jenis_koreksi < 4) {
            $data['kiba'] = $this->kiba_temp->select('temp_aset_a.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_a.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
            $data['kibb'] = $this->kibb_temp->select('temp_aset_b.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_b.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
            $data['kibc'] = $this->kibc_temp->select('temp_aset_c.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_c.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
            $data['kibd'] = $this->kibd_temp->select('temp_aset_d.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_d.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
            $data['kibe'] = $this->kibe_temp->select('temp_aset_e.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_e.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
            $data['kibg'] = $this->kibg_temp->select('temp_aset_g.*,original_value,corrected_value')->join('koreksi_detail', 'temp_aset_g.id_koreksi_detail=koreksi_detail.id')->get_many_by('id_koreksi', $id_koreksi);
        } else {
            $data['kiba'] = $this->kiba_temp->get_many_by('id_koreksi', $id_koreksi);
            $data['kibb'] = $this->kibb_temp->get_many_by('id_koreksi', $id_koreksi);
            $data['kibc'] = $this->kibc_temp->get_many_by('id_koreksi', $id_koreksi);
            $data['kibd'] = $this->kibd_temp->get_many_by('id_koreksi', $id_koreksi);
            $data['kibe'] = $this->kibe_temp->get_many_by('id_koreksi', $id_koreksi);
            $data['kibg'] = $this->kibg_temp->get_many_by('id_koreksi', $id_koreksi);
        }

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
        $result['data'] = $this->subtitute($this->get_all());
        $result['data'] = $this->fill_empty_data($result['data']);

        return $result;
    }

    public function api_get_data($id_organisasi, $jenis_koreksi = '', $filter = array())
    {
        $q = $filter['search'];

        $this->group_start();
        $this->or_like(array('tgl_jurnal'=>$q, 'keterangan'=>$q));
        $this->group_end();

        $clone = clone($this->db);
        $data['total'] = $clone->where(array('id_organisasi'=>$id_organisasi, 'jenis_koreksi'=>$jenis_koreksi))->from($this->_table)->count_all_results();

        $this->limit($filter['limit'], $filter['offset']);

        $data['rows']  = $this->as_array()->get_many_by(array('id_organisasi'=>$id_organisasi, 'jenis_koreksi'=>$jenis_koreksi));
        $data['rows']  = $this->subtitute($data['rows']);

        foreach ($data['rows'] as $index => $value) 
        {
            $value['tgl_jurnal'] = datify($value['tgl_jurnal']);
            $value['aksi']  = "<div class='btn-group'><a class='btn btn-primary btn-sm' href='".site_url('koreksi/atribut/index/rincian/'.$value['id'])."'><i class='fa fa-eye mr-2'></i>rincian</a>";
            $value['aksi'] .= "<button class='btn btn-danger btn-sm' data-id='".$value['id']."' ".($value['status_pengajuan']!=='0' && $value['status_pengajuan']!=='3' ?'disabled':'')."><i class='fa fa-trash'></i></button></div>";

            switch ($value['status_pengajuan']) {
                case 0:
                $value['status_pengajuan'] = "<button class='btn btn-secondary btn-sm'>draf</button>";
                break;
                case 1:
                $value['status_pengajuan'] = "<button class='btn btn-warning btn-sm'>menunggu</button>";
                break;
                case 2:
                $value['status_pengajuan']  = "<div class='btn-group'>";
                $value['status_pengajuan'] .= "<button class='btn btn-success btn-sm' data-id-koreksi='".$value['id']."'><i class='fa fa-comment-o mr-2'></i>disetujui</button>";
                $value['status_pengajuan'] .= "<button class='btn btn-warning' data-id-batal='".$value['id']."'><i class='fa fa-times'></i></button>";
                $value['status_pengajuan'] .= "</div>";
                break;
                case 3:
                $value['status_pengajuan'] = "<button class='btn btn-danger btn-sm' data-id-koreksi='".$value['id']."'><i class='fa fa-comment-o mr-2'></i>ditolak</button>";
                break;
            }

            $data['rows'][$index] = $value;
        }

        return $data;
    }

    public function api_get_data_persetujuan($jenis_koreksi = '', $filter = array())
    {
        $q = $filter['search'];

        $this->group_start();
        $this->or_like(array('tgl_jurnal'=>$q, 'keterangan'=>$q));
        $this->group_end();

        $clone = clone($this->db);
        $data['total'] = $clone->where(array('jenis_koreksi'=>$jenis_koreksi, 'status_pengajuan'=>1))->from($this->_table)->count_all_results();

        $this->limit($filter['limit'], $filter['offset']);

        $data['rows']  = $this->as_array()->get_many_by(array('jenis_koreksi'=>$jenis_koreksi, 'status_pengajuan'=>1));
        $data['rows']  = $this->subtitute($data['rows']);

        foreach ($data['rows'] as $index => $value) 
        {
            $value['tgl_jurnal'] = datify($value['tgl_jurnal']);
            $value['aksi'] = "<div class='btn-group'>";
            $value['aksi'] .= "<button class='btn btn-sm btn-success btn-setuju' data-id='".$value['id']."'><i class='fa fa-check'></i></button>";
            $value['aksi'] .= "<button class='btn btn-sm btn-danger btn-tolak' data-id='".$value['id']."'><i class='fa fa-times'></i></button>";
            $value['aksi'] .= "<a href='".site_url('koreksi/atribut/index/rincian/'.$value['id'].'?ref=true')."' class='btn btn-sm btn-secondary'><i class='fa fa-eye mr-2'></i>rincian</a>";
            $value['aksi'] .= "</div>";

            $data['rows'][$index] = $value;
        }

        return $data;
    }
}