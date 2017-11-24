<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_aset extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('report/Rekap_aset_model', 'report');
		$this->load->model('organisasi_model', 'organisasi');
	}
	
	public function index($jenis = null)
	{
		$data['organisasi'] = $this->organisasi->get_many_by(array('jenis'=>4));

		switch ($jenis) {
			case 17:
				$this->render('modules/report/rekap_aset/index_17', $data);
				break;
			case 13:
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
		$input['upb']	= $this->organisasi->get($input['id_organisasi'])->nama;
		$data['detail'] = $input;

		switch ($jenis) {
			case 17:
				$data['rekap']  = $this->report->get_rekapitulasi_aset_17($input['jenis'], $input['id_organisasi']);
				break;
			case 13:
				$data['rekap']  = $this->report->get_rekapitulasi_aset_13($input['jenis'], $input['id_organisasi']);
				break;
			default:
				show_404();
				break;
		}
		
		$this->render('modules/report/rekap_aset/cetak', $data);
	}
}