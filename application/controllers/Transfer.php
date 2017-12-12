<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 10/12/2017
 * Time: 21.20
 */

class Transfer extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Organisasi_model', 'organisasi');
	}

	public function index() {
		show_404();
	}

	public function masuk() {

	}

	public function keluar() {
		$filter = $this->input->get();
		$data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
		$filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

		# Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$filter['id_organisasi'] = $this->auth->get_id_organisasi();
			$data['organisasi'] = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
		}
		$data['filter'] = $filter;
		$this->render('modules/transfer/keluar', $data);
	}

	public function add($id = null) {
		if (empty($id)) {
			$this->message('Pilih UPB Terlebih Dahulu', 'warning');
			$this->go('transfer/keluar');
		}
		$data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
		$data['org'] = $this->organisasi->get($id);
		$this->render('modules/transfer/form', $data);
	}

	public function detail($id = null) {
		if (empty($id)) {
			show_404();
		}

		$data['id_transfer'] = $id;
		$this->render('modules/transfer/detail');
	}

	public function rincian($id = null) {
		if (empty($id)) {
			show_404();
		}
        # RINCIAN
        $data['kiba'] 	= null;
        $data['kibb'] 	= null;
        $data['kibc'] 	= null;
        $data['kibd'] 	= null;
        $data['kibe'] 	= null;
        $data['kibnon'] = null;
		$data['id_transfer'] = $id;
		$this->render('modules/transfer/rincian', $data);
	}
}