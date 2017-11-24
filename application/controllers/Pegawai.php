<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends MY_Controller {

	public $is_admin = 1;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pegawai_model', 'pegawai');
		$this->load->model('Organisasi_model', 'organisasi');
	}
	
	public function index()
	{
		# Load pagination library
		$this->load->library('Pagination', 'pagination');

		# Prepare data
		$filter = trim_empty_data($this->input->get());
		$result = $this->pegawai->get_data($filter);

		$data['pegawai'] 	= $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, get_class($this));
		$data['filter']		= $filter;
		$data['org_list']	= $this->organisasi->get_all();

		$this->render('modules/pegawai/index', $data);
	}

	public function add()
	{
		$data['org_list']	= $this->organisasi->get_all();
		$this->render('modules/pegawai/form', $data);
	}

	public function edit($id = NULL)
	{
		if (empty($id))
			show_404();

		$data['peg']		= $this->pegawai->get($id);
		$data['org_list']	= $this->organisasi->get_all();
		$this->render('modules/pegawai/form', $data);
	}

	public function insert()
	{
		$data = $this->input->post();

		# Verify empty data
		if (!$this->pegawai->form_verify($data)) {
			$this->message('Isi data yang perlu diisi', 'danger');
			$this->go('pegawai/add');
		}

		# Verify availablity username
		$result = $this->pegawai->get_by(array('username'=>$data['username']));
		if (!empty($result)) {
			$this->message('Username telah dipakai, gunakan username lainnya', 'danger');
			$this->go('pegawai/add');
		}

		# Verify password match
		if ($data['password'] !== $data['password_re']) {
			$this->message('Password tidak sama', 'danger');
			$this->go('pegawai/add');
		}

		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		unset($data['password_re']);

		$sukses = $this->pegawai->insert($data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go('pegawai/add');
		} else {
			$this->message('Data gagal ditambah','danger');
			$this->go('pegawai/add');
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id']);

		# If password want to be changed
		if (empty($data['password'])) {
			unset($data['password'], $data['password_re']);
		} else {
			if ($data['password'] !== $data['password_re']) {
				$this->message('Password tidak sama', 'danger');
				$this->go('pegawai/add');
			}

			$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
			unset($data['password_re']);
		}

		# Verify empty data
		if (!$this->pegawai->form_verify($data)) {
			$this->message('Isi data yang perlu diisi', 'danger');
			$this->go('pegawai/add');
		}

		# Verify availablity username
		$result = $this->pegawai->get_by(array('username'=>$data['username'], 'id<>'=>$id));
		if (!empty($result)) {
			$this->message('Username telah dipakai, gunakan username lainnya', 'danger');
			$this->go('pegawai/add');
		}

		$sukses = $this->pegawai->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil sunting','success');
			$this->go('pegawai');
		} else {
			$this->message('Data gagal sunting','danger');
			$this->go('pegawai/edit/'.$id);
		}
	}

	public function delete($id = NULL)
	{
		if (empty($id))
			show_404();

		$sukses = $this->pegawai->delete($id);
		if($sukses) {
			$this->message('Data berhasil dihapus','success');
			$this->go('pegawai');
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('pegawai');
		}
	}
}