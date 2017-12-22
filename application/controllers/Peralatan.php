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
		$data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
		$this->render('modules/peralatan/hapus_data', $data);
	}
}