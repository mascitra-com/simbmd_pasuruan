<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_aset extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('report/Rekap_aset_model', 'report');
		$this->load->model('organisasi_model', 'organisasi');
		$this->load->model('Auth_model', 'auth');
	}
	
	public function index($jenis = null)
	{
        $data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4));
        $data['id_organisasi'] = 0;
        # Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$data['id_organisasi'] = $this->auth->get_id_organisasi();
			$data['organisasi'] = $this->organisasi->get_many_by('id', $data['id_organisasi']);
		}

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

        if(empty($input['id_organisasi'])){
            $this->message('Pilih Organisasi', 'danger');
            $this->go('report/rekap_aset/index/'.$jenis);
        }

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