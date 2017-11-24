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
		// do{

		// }while(count(array_unique($result)) < count($result));

		$result = array();
		for($i=0;$i<100000;$i++){
			$result[] = strtoupper(uniqid().'.'.date('dmYhis'));
		}

		echo (count(array_unique($result)) === count($result)) ? 'TRUE': 'DUPLICATED';
	}
}