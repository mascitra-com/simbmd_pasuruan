<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekening extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Rekening_model', 'rekening');
	}

	public function get_data_search()
	{
		$key = $this->input->get('key');
		$result = $this->rekening->like('kode', $key)->or_like('uraian', $key)->limit(50)->get_all();

		echo json_encode($result);
	}
}