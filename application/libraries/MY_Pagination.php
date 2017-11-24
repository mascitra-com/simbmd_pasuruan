<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_pagination($total = 0, $filter = array(), $class = '')
	{
		$url = $class;

		unset($filter['page']);

		$is_first = TRUE;
		foreach ($filter as $key => $value)
		{
			$sep = ($is_first) ? '?' : '&';
			$url .= $sep.$key.'='.$value;
			$is_first = FALSE;
		}

        # base config
		$config['base_url']   = site_url($url);
		$config['total_rows'] = $total;
		$config['per_page']   = (isset($filter['limit'])) ? $filter['limit'] : 20;
		// $config['per_page']   = 1;
		$config['page_query_string'] 	= TRUE;
		$config['enable_query_strings'] = TRUE;
		$config['use_page_numbers'] 	= TRUE;
		$config['query_string_segment'] = 'page';

        # styling
		$config['attributes'] 		= array('class' => 'page-link');
		$config['full_tag_open']    = "<nav><ul class='pagination'>";
		$config['full_tag_close']   = "</ul></nav>";
		$config['num_tag_open']     = "<li class='page-item'>";
		$config['num_tag_close']    = "</li>";
		$config['first_tag_open']   = "<li class='page-item'>";
		$config['first_tag_close']  = "</li>";
		$config['last_tag_open']    = "<li class='page-item'>";
		$config['last_tag_close']   = "</li>";
		$config['next_tag_open']    = "<li class='page-item'>";
		$config['next_tag_close']   = "</li>";
		$config['prev_tag_open']    = "<li class='page-item'>";
		$config['prev_tag_close']   = "</li>";
		$config['cur_tag_open']     = "<li class='page-item active'><a class='page-link'>";
		$config['cur_tag_close']    = "</a></li>";
		$this->initialize($config);
		return $this->create_links();
	}
}