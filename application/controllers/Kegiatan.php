<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kegiatan extends MY_Controller {

	public $is_admin = 1;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kegiatan_model', 'kegiatan');
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Auth_model', 'auth');
	}
	
	public function index()
	{
		$id = $this->input->get('id_organisasi');
		$data['organisasi']    = $this->organisasi->get_data(array('jenis'=>4));
		
		# Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$id = $this->auth->get_id_organisasi();
			$data['organisasi']    = $this->organisasi->get_many_by('id', $id);
		}

		$data['kegiatan'] = (!empty($id)) ? $this->kegiatan->get_many_by('id_organisasi', $id): array();
		$data['id'] = $id;

		$this->render('modules/kegiatan/index', $data);
	}

	public function add($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('kegiatan');
		}

		$data['organisasi'] = $this->organisasi->get($id);
		$this->render('modules/kegiatan/form', $data);
	}

	public function edit($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('kegiatan');
		}

		$data['kegiatan'] 	= $this->kegiatan->get($id);
		$data['organisasi'] = $this->organisasi->get($data['kegiatan']->id_organisasi);
		$this->render('modules/kegiatan/form', $data);
	}

	public function insert()
	{
		$data = $this->input->post();

		if (!$this->kegiatan->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('kegiatan/add/'.$data['id_organisasi']);
		}

		$sukses = $this->kegiatan->insert($data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go('kegiatan?id_organisasi='.$data['id_organisasi']);
		} else {
			$this->message('Data gagal ditambah','danger');
			$this->go('kegiatan/add/'.$data['id_organisasi']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->kegiatan->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('kegiatan/edit/'.$id);
		}

		$sukses = $this->kegiatan->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go('kegiatan?id_organisasi='.$data['id_organisasi']);
		} else {
			$this->message('Data gagal ditambah','danger');
			$this->go('kegiatan/edit/'.$id);
		}
	}

	public function delete($id = NULL)
	{
		if(empty($id))
			show_404();

		$sukses = $this->kegiatan->delete($id);
		if($sukses) {
			$this->message('Data berhasil dihapus','success');
			$this->go('kegiatan');
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('kegiatan');
		}
	}
}