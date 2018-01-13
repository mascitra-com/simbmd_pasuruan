<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 1/13/2018
 * Time: 3:21 PM
 */

class Label extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Label_model', 'label');
        $this->load->model('organisasi_model', 'organisasi');
        $this->load->model('pegawai_model', 'pegawai');
        $this->load->model('Auth_model', 'auth');
    }

    public function index()
    {
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['id_organisasi'] = 0;
        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $data['id_organisasi'] = $this->auth->get_id_organisasi();
        }
        $this->render('modules/labelisasi/index', $data);
    }

    public function cetak()
    {
        $input = $this->input->post();

        if (empty($input['id_ruangan'])) {
            $this->message('Isi data yang perlu diisi', 'danger');
            $this->go('report/rekap_ruangan');
        }

        $data['detail'] = $input;
        $data['labels'] = $this->label->get_data_label($input['id_ruangan']);
        $this->render("modules/labelisasi/cetak", $data);
    }
}