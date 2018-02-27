<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembaharuan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->render('modules/dashboard/pembaharuan');
	}
}