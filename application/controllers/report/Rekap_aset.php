<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_aset extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('report/Rekap_aset_model', 'report');
		$this->load->model('report/Rekap_aset_saldo_model', 'report_saldo');
		$this->load->model('organisasi_model', 'organisasi');
        $this->load->model('pegawai_model', 'pegawai');
        $this->load->model('Auth_model', 'auth');
	}
	
	public function index($jenis = null)
	{
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['id_organisasi'] = 0;

        # Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$data['id_organisasi'] = $this->auth->get_id_organisasi();
		}

		switch ($jenis) {
			case 17:
                $data = array_merge($data, $this->pegawai->get_cookie_pegawai(array('melaporkan_aset17', 'mengetahui_aset17')));
                $this->render('modules/report/rekap_aset/index_17', $data);
				break;
			case 13:
                $data = array_merge($data, $this->pegawai->get_cookie_pegawai(array('melaporkan_aset13', 'mengetahui_aset13')));
                $this->render('modules/report/rekap_aset/index_13', $data);
				break;
			default:
				show_404();
				break;
		}
	}

	public function cetak($jenis = null)
	{
		$input = $this->input->post();

        if(empty($input['id_organisasi'])){
            $this->message('Pilih Organisasi', 'danger');
            $this->go('report/rekap_aset/index/'.$jenis);
        }
        if(strpos($input['id_organisasi'], '.'))
            $input['upb']	= 'SEMUA ' . $this->organisasi->get_org_induk($input['id_organisasi'])->nama;
        else
            $input['upb']	= $input['id_organisasi']==='all' ? 'Kabupaten' :$this->organisasi->get($input['id_organisasi'])->nama;
		$data['detail'] = $input;

        switch ($jenis) {
			case 17:
				if ($input['sumber_data']==1) {
					$data['rekap'] = $this->report->get_rekapitulasi_aset_17($input['jenis'], $input['id_organisasi']);
				} else {
					$data['rekap'] = $this->report_saldo->get_rekapitulasi_aset_17($input['jenis'], $input['id_organisasi']);
				}
				break;
			case 13:
				if ($input['sumber_data']==1) {
					$data['rekap'] = $this->report->get_rekapitulasi_aset_13($input['jenis'], $input['id_organisasi']);
				} else {
					$data['rekap'] = $this->report_saldo->get_rekapitulasi_aset_13($input['jenis'], $input['id_organisasi']);
				}
				break;
			default:
				show_404();
				break;
		}
		$this->render('modules/report/rekap_aset/cetak', $data);
	}
}