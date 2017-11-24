<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends MY_Controller
{
	public $is_superadmin = 1;
	private $temp = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Organisasi_model','organisasi');
		$this->init_temp();
	}
	
	public function index()
	{
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4));
		$this->render('modules/backup/import/index', $data);
	}

	public function upload()
	{
		# GET & VALIDATE DATA
		$data = $this->input->post();
		
		if (empty($data['kd_upb']) OR empty($data['kib'])) {
			$this->message('Data KIB dan UPB harus dipilih','danger');
			$this->go('backup/import');
		}

		# Empty Session
		$this->reset_temp();
		$temp = array();

		# BEGIN UPLOAD
		if ($_FILES['berkas']['size'] > 0) {
			$config['upload_path']   = realpath(FCPATH.'/res/docs/temp/');
			$config['file_name']	 = date('Ymdhis').uniqid();
			$config['allowed_types'] = 'xls|xlsx';
			$config['max_size']      = 9000;
			$config['overwrite']     = TRUE;

			$this->load->library('upload', $config);
			
			# Jika gagal
			if (!$this->upload->do_upload('berkas')) {
				$this->message($this->upload->display_errors(), 'danger');
				$this->go('backup/on_process');
			}

			$temp['file_name']     = $this->upload->data('file_name');
			$temp['kib']	       = $data['kib'];
			$temp['id_organisasi'] = $data['kd_upb'];
			$temp['data'] 		   = array();
			$temp['data_error']    = array();
			$temp['status'] 	   = 0;

			$this->session->set_userdata('temp_import', $temp);
			$this->go('backup/import/on_process');
		}

		$this->message('Pilih file terlebih dahulu', 'danger');
		$this->go('backup/import');
	}

	public function on_process()
	{
		if (!$this->is_status_clear(0)) {
			show_404();
		}

		$this->render('modules/backup/import/loading');
	}

	public function do_process()
	{
		if (!$this->is_status_clear(0)) {
			echo 'false';
			exit(0);
		}

		# Lock process
		$this->temp['status'] = 1;
		$this->update_temp();

		# Proses ambil data
		$this->load->library('Excel');
		
		$file_name 		= $this->session->temp_import['file_name'];
		$config['file'] = realpath(FCPATH.'/res/docs/temp/'.$file_name);
		$config['startRow'] = 2;

		$result = $this->excel->import($config);
		
		if (empty($result)) {
			echo 'false';
			exit(0);
		}

		# Ubah format siap insert
		$kib = 'aset/kib'.$this->session->temp_import['kib'].'_model';
		$this->load->model($kib, 'kib');
		$this->kib->fix_data_import($result);
		
		# Delete file
		unlink($config['file']);

		# Return
		echo 'true';
	}

	public function insert()
	{
		if (!$this->is_status_clear(1)) {
			show_404();
		}

		if (!empty($this->session->temp_import['data_error'])) {
			$this->go('backup/import/has_error');
		}

		$kib = 'aset/kib'.$this->session->temp_import['kib'].'_model';
		$this->load->model($kib, 'kib');
		$sukses = $this->kib->batch_insert($this->session->temp_import['data']);
		
		if($sukses) {
			$this->message('Data berhasil diimport','success');
		} else {
			$this->message('Data gagal diimport','danger');
		}

		$this->reset_temp();
		$this->go('backup/import');
	}

	public function has_error()
	{
		$this->render('modules/backup/import/has_error');
	}

	private function is_status_clear($status)
	{
		if (!$this->session->has_userdata('temp_import')) {
			return FALSE;	
		}

		if ($this->session->temp_import['status'] !== $status) {
			return FALSE;
		}

		return TRUE;
	}

	private function init_temp()
	{
		if ($this->is_status_clear(0)) {
			$this->temp = $this->session->temp_import;
		}
	}

	private function update_temp()
	{
		$this->session->unset_userdata('temp_import');
		$this->session->set_userdata('temp_import', $this->temp);
	}

	private function reset_temp()
	{
		$this->session->unset_userdata('temp_import');
	}
}