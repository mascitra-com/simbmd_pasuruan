<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Auth_model extends MY_Model {

	public $_table = 'user';

	public function __construct()
	{
		parent::__construct();
	}

	public function is_loggedin()
	{
		if ($this->session->has_userdata('auth'))
		{
			$data = $this->session->auth;

			return (isset($data['is_loggedin']) && $data['is_loggedin']===TRUE);
		}

		return FALSE;
	}

	public function get_id()
	{
		if ($this->session->has_userdata('auth')) {
			$data = $this->session->auth;
			if (isset($data['id']) && !empty($data['id'])) {
				return $data['id'];
			}
		}

		return '';
	}

	public function get_id_organisasi()
	{
		if ($this->session->has_userdata('auth')) {
			$data = $this->session->auth;
			if (isset($data['id_organisasi']) && !empty($data['id_organisasi'])) {
				return $data['id_organisasi'];
			}
		}

		return '';
	}

	public function get_access()
	{
		if ($this->session->has_userdata('auth')) {
			$data = $this->session->auth;
			if (isset($data['is_admin']) && !empty($data['is_admin'])) {
				return $data['is_admin'];
			}
		}

		return '';
	}

	public function get_super_access()
	{
		if ($this->session->has_userdata('auth')) {
			$data = $this->session->auth;
			if (isset($data['is_superadmin']) && !empty($data['is_superadmin'])) {
				return $data['is_superadmin'];
			}
		}

		return '';
	}

	public function authenticate($username, $password)
	{
		$result = $this->get_by(array('username'=>$username));

		if ($result) 
		{
			if (password_verify($password, $result->password))
			{
				return $result;
			}
			else
			{
				return FALSE;
			}
		}

		return FALSE;
	}

	public function write_signature($data)
	{
		$this->update_last_login($data->id);

		$this->session->unset_userdata('auth');
		$data = array(
			'is_loggedin'=>TRUE,
			'ip_address'=>$this->input->ip_address(),
			'id'=>$data->id,
			'name'=>$data->nama,
			'id_organisasi'=>$data->id_organisasi,
			'is_admin'=>$data->is_admin,
			'is_superadmin'=>$data->is_superadmin
			);
		$this->session->set_userdata('auth', $data);
	}

	private function update_last_login($id)
	{
		$this->update($id, array('last_login'=>date('Y-m-d h:i:s')));
	}
}