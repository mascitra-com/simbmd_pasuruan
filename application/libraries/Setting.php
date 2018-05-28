<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting 
{
	private $path;

	public function __construct()
	{
		$this->path = realpath(APPPATH.'config/setting.json');
	}

	public function get_all()
	{
		return $this->gets();
	}

	public function get($conf_name = null)
	{
		if (empty($conf_name)) {
			return false;
		}

		$config = $this->gets();
		
		return property_exists($config, $conf_name) ? $config->{$conf_name} : false;
	}

	public function update_config($data = array())
	{
		$config = $this->gets();
		foreach ($data as $key => $value) {
			$config->{$key} = $value;
		}

		return $this->sets($config);
	}

	private function gets()
	{
		return json_decode(file_get_contents($this->path));
	}

	private function sets($data)
	{
		return file_put_contents($this->path, json_encode($data));
	}
}