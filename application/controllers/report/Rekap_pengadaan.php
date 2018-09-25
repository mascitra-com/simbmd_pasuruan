<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_pengadaan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('report/Rekap_pengadaan_model', 'report');
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

		$this->render('modules/report/rekap_pengadaan/index', $data);
	}

	public function cetak()
	{
		$input = $this->input->post();

		if (empty($input['id_organisasi'])) {
			$this->message('Pilih UPB terlebih dahulu', 'danger');
			$this->go('report/rekap_pengadaan');
		}

		if (!isset($input['pengelompokan'])) {
			$input['pengelompokan'] = 1;
		}

		switch ($input['id_organisasi']) {
			case 'all':
			$input['upb'] = 'KABUPATEN';
			break;
			case '7.1':
			$input['upb'] = 'DINAS KESEHATAN';
			break;
			case '8.1':
			$input['upb'] = 'DINAS PENDIDIKAN';
			break;
			default:
			$input['upb'] = $this->organisasi->get($input['id_organisasi'])->nama;
			break;
		}

		$data['detail'] = $input;
		$data['rekap']  = $this->report->get_rekapitulasi($input);

		if ($input['pengelompokan']==1) {
			$this->render('modules/report/rekap_pengadaan/cetak', $data);
		}else{
			$this->render('modules/report/rekap_pengadaan/cetak_kategori', $data);
		}
	}
}