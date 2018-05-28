<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MY_Controller {
	public $is_superadmin = 1;

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$data['pengaturan'] = $this->setting->get_all();
		$this->render('modules/pengaturan/index', $data);
	}

	public function update()
	{
		$data = $this->input->post();

		$sukses = $this->setting->update_config($data);
		if($sukses) {
			$this->message('Pengaturan berhasil disimpan','success');
		} else {
			$this->message('Pengaturan gagal disimpan','danger');
		}

		$this->go('pengaturan');
	}
}