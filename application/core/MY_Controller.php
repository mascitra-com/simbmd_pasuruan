<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MY_Base_controller {

	public $is_admin = 0;
	public $is_superadmin = 0;
	public $maintenance_time = '25';
	public $maintenance_status = '0';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'auth');
	}

	public function _remap($method, $params = array())
	{
		# MAINTENANCE
		if (date('G') !== $this->maintenance_time AND $this->maintenance_status == '0')
		{
			# ACCESS PRIORITY
			if ($this->check_priority())
			{
				# METHOD
				if (method_exists($this, $method))
				{
					# LOGGED IN
					if ($this->auth->is_loggedin())
					{
						# IS ALLOWED
						if ($this->is_class_allowed())
						{
							return call_user_func_array(array($this, $method), $params);
						}
						else
						{
							show_404();
						}
					}
					else
					{
						$this->go('masuk');
					}
				}
				show_404();
			}
			else
			{
				show_error("Mohon maaf akses aplikasi saat ini sedang dibatasi. Silahkan menghubungi admin pusat untuk info lebih lanjut.", 500, 'Maintenance');
			}
		}
		else if(date('G') == $this->maintenance_time)
		{
			show_error("Website Sedang Dalam Proses Maintenance. Website Akan Kembali Aktif Pada Pukul 01.00 WIB", 500, 'Maintenance');
		} else {
			show_error("Website Sedang Dalam Proses Maintenance.", 500, 'Maintenance');
		}
	}

	protected function render($view, $data = array())
	{
		$this->load->model('Dashboard_model', 'dashboard');
		$data['notif'] = $this->dashboard->get_notification();
		$this->blade->render($view, $data);
	}

	private function is_class_allowed()
	{
		$is_admin = $this->auth->get_access();
		$is_superadmin = $this->auth->get_super_access();

		$access = ($this->is_admin == 0 OR $this->is_admin == $is_admin);
		$super_access = ($this->is_superadmin == 0 OR $this->is_superadmin == $is_superadmin);
		$unlocked = !in_array($this->uri->segment(1), $this->setting->get('lock_menu'));

		return $access && $super_access && $unlocked;
	}

	private function check_priority()
	{
		$is_superadmin = $this->auth->get_super_access();
		$is_kepala = $this->auth->get_kepala_access();

		if ($is_superadmin === '1' OR $this->setting->get('access_priority') === '0') {
			return TRUE;
		}

		if ($is_kepala === '1' && $this->setting->get('access_priority') === '1') {
			return TRUE;
		}

		return FALSE;
	}
}
