<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MY_Base_controller {

	public $is_admin = 0;
	public $is_superadmin = 0;
	public $maintenance_time = '0';
	public $maintenance_status = '0';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'auth');
	}

	public function _remap($method, $params = array())
	{
		if (date('G') !== $this->maintenance_time AND $this->maintenance_status == '0')
		{
			if (method_exists($this, $method))
			{
				if ($this->auth->is_loggedin())
				{
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
		else if(date('G') == $this->maintenance_time)
		{
            show_error("Website Sedang Dalam Proses Maintenance. Website Akan Kembali Aktif Pada Pukul 01.00 WIB", 500, 'Maintenance');
		} else {
            show_error("Website Sedang Dalam Proses Maintenance.", 500, 'Maintenance');
        }
	}

	private function is_class_allowed()
	{
		$is_admin = $this->auth->get_access();
		$is_superadmin = $this->auth->get_super_access();

		$access = ($this->is_admin == 0 OR $this->is_admin == $is_admin);
		$super_access = ($this->is_superadmin == 0 OR $this->is_superadmin == $is_superadmin);

		return $access && $super_access;
	}
}
