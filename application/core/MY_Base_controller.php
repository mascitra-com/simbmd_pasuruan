<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Base_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->init();
	}

	private function init()
	{
		date_default_timezone_set('Asia/Jakarta');
	}

	protected function render($view, $data = array())
	{
		$this->blade->render($view, $data);
	}

	protected function go($link = '')
	{
		redirect(site_url($link));
	}

	protected function message($message, $message_type = 'info')
	{
		$this->session->set_flashdata('message', array($message,$message_type));
	}
}