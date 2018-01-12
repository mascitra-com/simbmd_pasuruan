<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_ruangan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('report/Rekap_ruangan_model', 'report');
		$this->load->model('Ruangan_model', 'ruangan');
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
		if($id = get_cookie('default_pegawai_ruangan')){
            $data['pegawai'] = $this->pegawai->get($id);
        } else {
            $data['pegawai'] = $this->pegawai->get($this->auth->get_id());
        }
		$this->render('modules/report/rekap_ruangan/index', $data);
	}

	public function cetak()
	{
		$input = $this->input->post();

		if (empty($input['id_ruangan'])) {
			$this->message('Isi data yang perlu diisi', 'danger');
			$this->go('report/rekap_ruangan');
		}

		$data['ruangan'] = $this->ruangan->as_array()->get($input['id_ruangan']);
		$data['upb'] = $this->organisasi->as_array()->get($input['id_organisasi']);
		$data['detail'] = $input;
		$data['rekap']  = $this->report->get_rekapitulasi($input['id_ruangan']);
		$this->render("modules/report/rekap_ruangan/cetak", $data);
	}
}