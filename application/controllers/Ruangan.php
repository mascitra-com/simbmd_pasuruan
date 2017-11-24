<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruangan extends MY_Controller {

	public $is_admin = 1;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Ruangan_model', 'ruangan');
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Auth_model', 'auth');
	}
	
	public function index()
	{
		$id = $this->input->get('id_organisasi');
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4));
		
		# Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$id = $this->auth->get_id_organisasi();
			$data['organisasi']    = $this->organisasi->get_many_by('id', $id);
		}

		$data['ruangan'] = (!empty($id)) ? $this->ruangan->get_many_by('id_organisasi', $id): array();
		$data['id'] = $id;

		$this->render('modules/ruangan/index', $data);
	}

	public function add($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('ruangan');
		}

		$data['organisasi'] = $this->organisasi->get($id);
		$this->render('modules/ruangan/form', $data);
	}

	public function edit($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('ruangan');
		}

		$data['ruangan'] 	= $this->ruangan->get($id);
		$data['organisasi'] = $this->organisasi->get($data['ruangan']->id_organisasi);
		$this->render('modules/ruangan/form', $data);
	}

	public function insert()
	{
		$data = $this->input->post();

		if (!$this->ruangan->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('ruangan/add/'.$data['id_organisasi']);
		}

		$sukses = $this->ruangan->insert($data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go('ruangan?id_organisasi='.$data['id_organisasi']);
		} else {
			$this->message('Data gagal ditambah','danger');
			$this->go('ruangan/add/'.$data['id_organisasi']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->ruangan->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('ruangan/edit/'.$id);
		}

		$sukses = $this->ruangan->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('ruangan?id_organisasi='.$data['id_organisasi']);
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go('ruangan/edit/'.$id);
		}
	}

	public function delete($id = NULL)
	{
		if(empty($id))
			show_404();

		$sukses = $this->ruangan->delete($id);
		if($sukses) {
			$this->message('Data berhasil dihapus','success');
			$this->go('ruangan');
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('ruangan');
		}
	}
}