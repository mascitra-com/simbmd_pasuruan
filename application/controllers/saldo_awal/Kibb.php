<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibb extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Saldo_kibb_model', 'kib');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->library('pagination');
    }

    public function index()
    {
        $filter = $this->input->get();

        $data['organisasi']      = $this->organisasi->get_data(array('jenis' => 4));
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $filter['id_organisasi'] = $this->auth->get_id_organisasi();
            $data['organisasi']      = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
        }

        $result = $this->kib->get_data($filter);
        $data['kib']        = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this));
        $data['filter']     = (!empty($filter) ? $filter : array('id_organisasi' => ''));

        $this->render('modules/aset/saldo_awal/kibb/index', $data);
    }
}