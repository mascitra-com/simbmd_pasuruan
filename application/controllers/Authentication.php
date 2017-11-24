<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends MY_Base_controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'auth');
	}

	public function index()
	{
		if ($this->auth->is_loggedin()) 
		{
			$this->go('dashboard');
		}
		else
		{
			$this->render('modules/auth/login');
		}
	}

	public function do_login()
	{
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		$result	  = $this->auth->authenticate($username, $password);
		if ($result) 
		{
			$this->auth->write_signature($result);
			$this->go('dashboard');
		}
		else
		{
			$this->message('Username atau password salah');
			$this->go('masuk');
		}
	}

	public function do_logout()
	{
		$this->session->sess_destroy();
		$this->go('masuk');
	}
}
