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
		$data['id_organisasi'] = !empty($this->input->get('id_organisasi'))?$this->input->get('id_organisasi'):0;
		$data['id_organisasi'] = $this->organisasi->get_id_by_auth($data['id_organisasi']);
		$data['organisasi'] 	  = $this->organisasi->get_data_by_auth();
		$this->render('modules/pegawai/index', $data);
	}

	public function get()
	{
		$filter = $this->input->get();
		$filter = $this->set_filter($filter);

		echo json_encode($this->pegawai->get_data($filter));
	}

	private function set_filter($filter = array())
	{
		$kolom = array('nip', 'user.nama', 'jabatan');

		if (isset($filter['search'])) {
			foreach ($kolom as $key => $value) {
				$filter[$value] = $filter['search'];
			}
		}
		return $filter;
	}

	public function insert()
	{
		$data = $this->input->post();

		if (!$this->pegawai->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('pegawai/index?id_organisasi='.$data['id_organisasi']);
		}

		if (!$this->check_password($data)) {
			$this->message('Password tidak match', 'danger');
			$this->go('pegawai/index?id_organisasi='.$data['id_organisasi']);
		}

		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		unset($data['re_password']);

		$this->pegawai->insert($data);
		$this->message('Data berhasil ditambah', 'success');
		$this->go('pegawai/index?id_organisasi='.$data['id_organisasi']);

	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];

		if(!empty($data['password'])){
			if (!$this->check_password($data)) {
				$this->message('Password tidak match', 'danger');
				$this->go('pegawai/index?id_organisasi='.$data['id_organisasi']);
			}
			$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		}else{
			unset($data['password']);
		}

		unset($data['id'], $data['re_password']);

		$this->pegawai->update($id, $data);

		$this->message('Data berhasil disunting', 'success');
		$this->go('pegawai/index?id_organisasi='.$data['id_organisasi']);
	}

	private function check_password($data)
	{
		return !empty($data['password']) && !empty($data['re_password']) && $data['password'] === $data['re_password'];
	}

	public function delete($id = null)
	{
		if (empty($id)) {
			show_404();
		}

		$id_organisasi = $this->pegawai->get($id)->id_organisasi;
		$this->pegawai->delete($id);
		$this->message('Data berhasil dihapus', 'success');
		$this->go('pegawai/index?id_organisasi='.$id_organisasi);
	}
}