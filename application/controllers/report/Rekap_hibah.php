<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_hibah extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('report/Rekap_hibah_model', 'report');
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
        $data = array_merge($data, $this->pegawai->get_cookie_pegawai(array('melaporkan_hibah', 'mengetahui_hibah')));

		$this->render('modules/report/rekap_hibah/index', $data);
	}

	public function cetak()
	{
		$input = $this->input->post();

		if (empty($input['id_organisasi'])) {
			$this->message('Pilih UPB terlebih dahulu', 'danger');
			$this->go('report/rekap_hibah');
		}

		$input['upb']	= $this->organisasi->get($input['id_organisasi'])->nama;
		
		$data['detail'] = $input;
		$data['rekap']  = $this->report->get_rekapitulasi($data['detail']);

		// dump($data);
		$this->render('modules/report/rekap_hibah/cetak', $data);
	}
}