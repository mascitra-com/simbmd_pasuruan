<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->render('modules/dashboard/index');
	}

	public function tes()
	{
		$this->load->model('Aset/Kiba_model', 'kib');
		$filter = array('id'=>3, 'id_organisasi'=>172);
		dump($this->kib->get_data_aset($filter));
	}
}