<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_transfer extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('report/Rekap_transfer_model', 'report');
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

		$this->render('modules/report/rekap_transfer/index', $data);
	}

	public function cetak()
	{
		$input = $this->input->post();

		if (empty($input['id_organisasi'])) {
			$this->message('Pilih UPB terlebih dahulu', 'danger');
			$this->go('report/rekap_transfer');
		}

		$input['upb']	= $this->organisasi->get($input['id_organisasi'])->nama;
		
		$data['rekap']  = $this->report->get_rekapitulasi($input);
		$data['detail'] = $input;

		$this->render('modules/report/rekap_transfer/cetak', $data);
	}
}