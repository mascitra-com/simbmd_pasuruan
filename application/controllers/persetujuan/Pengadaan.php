<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengadaan extends MY_Controller {

	public $is_superadmin = 1;

	public function __construct() {
		parent::__construct();
		$this->load->model('Spk_model', 'spk');
        $this->load->model('Persetujuan_model', 'persetujuan');
        $this->load->model('Organisasi_model', 'organisasi');
    }

    public function index() {
		$this->load->library('Pagination');

		$filter = $this->input->get();
		$filter['status_pengajuan'] = '1';
		$filter['ord_by'] = 'log_time';
		$filter['ord_pos'] = 'DESC';
		$result = $this->spk->get_data_persetujuan($filter);

		$data['spks'] = $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'persetujuan_transfer');
		$data['filter'] = $filter;

		$this->render('modules/persetujuan/Pengadaan/index', $data);
	}
}