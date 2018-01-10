<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibd extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Saldo_kibd_model', 'kib');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->library('pagination');
    }

    public function index()
    {
        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        $filter['is_kdp']        = false;

        $data['organisasi'] = $this->organisasi->get_data_by_auth();

        $result = $this->kib->get_data($filter);
        $data['kib']        = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this));
        $data['filter']     = (!empty($filter) ? $filter : array('id_organisasi' => ''));

        $this->render('modules/aset/saldo_awal/kibd/index', $data);
    }
}