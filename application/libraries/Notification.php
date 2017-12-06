<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification 
{
	protected $table = 'notifikasi';
	protected $CI;
	protected $title;
	protected $decription;
	protected $link;
	protected $from;
	protected $to;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
	}

	public function init($config = array())
	{
		foreach ($config as $key => $value)
		{
			$this->{$key} = $value;
		}
	}

	public function set($config = array())
	{
		# Set config if available
		if (!empty($config))
			$this->init($config);

		$data = array(
			'title'=>$this->title,
			'description'=>$this->description,
			'link'=>$this->link,
			'from'=>$this->from,
			'to'=>$this->to,
			'is_read'=>0,
            'create_time' => date('Y-m-d h:i:s'),
		);

		return $this->CI->db->insert($this->table, $data);
	}

	public function get($to = null)
	{
		$this->CI->db->where('to', $to);
		return $this->CI->db->get($this->table)->result();
	}

	public function get_unread($to = null)
	{
		$this->CI->db->where('to', $to)->where('is_read', 0);
		return $this->CI->db->get($this->table)->result();
	}
}