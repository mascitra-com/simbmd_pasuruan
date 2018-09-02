<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibe extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kibe_model', 'kib');
        $this->load->model('aset/Temp_kibe_model', 'kib_temp');
        $this->load->model('Transfer_model', 'transfer');
        $this->load->library('pagination');
    }

    public function add($id_transfer = NULL)
    {
        if (empty($id_transfer))
            show_404();

        $data['transfer'] = $this->transfer->get($id_transfer);
        $where_not_in     = $this->kib_temp->select('id_aset')->as_array()->get_many_by('id_transfer', $id_transfer);
        $where_not_in     = array_column($where_not_in, 'id_aset');
        
        # FILTER
        $filter = $this->input->get();
        $filter['id_organisasi'] =  $data['transfer']->id_organisasi;

        $result = $this->kib->where_not_in('id', !empty($where_not_in)?$where_not_in:'')->get_data($filter);

        $data['filter']         = $filter;
        $data['kib']            = $result['data'];
        $data['terpilih_count'] = count($where_not_in);
        $data['pagination']     = $this->pagination->get_pagination($result['data_count'], $filter, 'transfer/'.get_class($this).'/add/'.$id_transfer);
        $this->render('modules/transfer/kibe', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $kib  = $this->kib->as_array()->get($data['id_aset']);

        $kib['id_transfer'] = $data['id_transfer'];
        $kib['id_aset']     = $data['id_aset'];

        unset($kib['id'], $kib['id_spk'], $kib['id_sp2d'], $kib['id_hibah']);

        $sukses = $this->kib_temp->insert($kib);
        if($sukses) {
            $terpilih_count = $this->kib_temp->count_by('id_transfer', $data['id_transfer']);
            echo json_encode(array('status'=>'sukses', 'terpilih_count'=> $terpilih_count));
        }
    }

    public function delete($id = NULL)
    {
        if (empty($id))
            show_404();

        $id_transfer = $this->kib_temp->get($id)->id_transfer;
        $sukses      = $this->kib_temp->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('transfer/index/rincian/'.$id_transfer.'?ref=keluar');
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('transfer/index/rincian/'.$id_transfer.'?ref=keluar');
        }
    }
}