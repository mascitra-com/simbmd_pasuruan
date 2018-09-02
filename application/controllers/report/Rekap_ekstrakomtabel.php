<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_ekstrakomtabel extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('report/Rekap_ekstrakomtabel_model', 'report');
        $this->load->model('organisasi_model', 'organisasi');
        $this->load->model('Auth_model', 'auth');
        $this->load->model('pegawai_model', 'pegawai');
    }

    public function index()
    {
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['id_organisasi'] = 0;
        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $data['id_organisasi'] = $this->auth->get_id_organisasi();
        }
        $data = array_merge($data, $this->pegawai->get_cookie_pegawai(array('melaporkan_kib', 'mengetahui_kib')));

        $this->render('modules/report/rekap_ekstrakomtabel/index', $data);
    }

    public function cetak()
    {
        $input = $this->input->post();

        if (empty($input['id_organisasi']) OR empty($input['kd_pemilik']) OR empty($input['kib'])) {
            $this->message('Isi data yang perlu diisi', 'danger');
            $this->go('report/rekap_ekstrakomtabel');
        }

        if(strpos($input['id_organisasi'], '.')) {
            $input['upb'] = 'SEMUA ' . $this->organisasi->get_org_induk($input['id_organisasi'])->nama;
        }
        else {
            $input['upb'] = $input['id_organisasi']==='all' ? 'Kabupaten' :$this->organisasi->get($input['id_organisasi'])->nama;
        }

        $data['detail'] = $input;
        $data['rekap'] = $this->report->get_rekapitulasi($data['detail']);

        $view = 'cetak_' . $input['kib'];
        $this->render("modules/report/rekap_ekstrakomtabel/{$view}", $data);
    }
}