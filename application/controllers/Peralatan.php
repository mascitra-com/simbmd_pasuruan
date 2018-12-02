<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peralatan extends MY_Controller {

	public $is_superadmin = 1;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Organisasi_model', 'organisasi');
	}

	public function hapus_data()
	{
		$data['organisasi'] = $this->organisasi->get_many_by(array('jenis' => 4));
		$this->render('modules/peralatan/hapus_data', $data);
	}

	public function do_hapus()
	{
		$data = $this->input->post();

		if (empty($data['id_organisasi']) OR empty($data['kib'])) {
			$this->message('Pilih data yang diperlukan', 'danger');
			$this->go('peralatan/hapus_data');
		}

		$this->load->model('aset/Saldo_kib'.$data['kib'].'_model', 'saldo');
		$this->load->model('aset/Kib'.$data['kib'].'_model', 'kib');

		$this->saldo->delete_by('id_organisasi', $data['id_organisasi']);
		$this->kib->delete_by('id_organisasi', $data['id_organisasi']);

		$this->message('Data pada saldo awal berhasil dikosongkan','success');
		$this->go('peralatan/hapus_data');
	}
}