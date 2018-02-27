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
		// $update = array("1.0"=>array("date"=>"xxx", "detail"=>array(array("jenis"=>"xxx", "deskripsi"=>"abc"), array("jenis"=>"xxx", "deskripsi"=>"abc"))));
		// echo json_encode($update);
	}
}