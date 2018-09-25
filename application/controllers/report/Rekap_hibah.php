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
		$data['id_organisasi'] = $this->organisasi->get_id_by_auth();

		$this->render('modules/report/rekap_hibah/index', $data);
	}

	public function cetak()
	{
		$input = $this->input->post();

		if (empty($input['id_organisasi'])) {
			$this->message('Pilih UPB terlebih dahulu', 'danger');
			$this->go('report/rekap_hibah');
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
		$data['rekap']  = $this->report->get_rekapitulasi($data['detail']);

		$this->render('modules/report/rekap_hibah/cetak', $data);
	}
}