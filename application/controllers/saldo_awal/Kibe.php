<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibe extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Saldo_kibe_model', 'kib');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->library('pagination');
    }

    public function index()
    {
        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

        $data['organisasi'] = $this->organisasi->get_data_by_auth();

        $result = $this->kib->get_data($filter);
        $data['kib']        = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'saldo_awal/' . get_class($this));
        $data['filter']     = (!empty($filter) ? $filter : array('id_organisasi' => ''));

        $this->render('modules/aset/saldo_awal/kibe/index', $data);
    }
}