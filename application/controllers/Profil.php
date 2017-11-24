<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'auth');
		$this->load->model('Profil_model', 'profil');
	}
	
	public function index()
	{
		$data['profil'] = $this->profil->get($this->auth->get_id());
		$this->render('modules/profil/index', $data);
	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->profil->form_verify($data)) {
			$this->message('Isi data yang wajib diisi','danger');
			$this->go('profil');
		}

		$sukses = $this->profil->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('profil');
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go('profil');
		}
	}

	public function update_akun()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->profil->form_verify($data)) {
			$this->message('Isi data yang wajib diisi','danger');
			$this->go('profil');
		}

		# Verify availablity username
		$result = $this->profil->get_by(array('username'=>$data['username'], 'id<>'=>$id));
		if (!empty($result)) {
			$this->message('Username telah dipakai, silahkan gunakan username lainnya', 'danger');
			$this->go('profil');
		}

		if (!empty($data['password']))
		{
			if ($data['password'] === $data['password_re']) {
				$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
				unset($data['password_re']);
			} else {
				$this->message('Password tidak sama','danger');
				$this->go('profil');
			}
		}
		else
		{
			unset($data['password'], $data['password_re']);
		}

		$sukses = $this->profil->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('profil');
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go('profil');
		}
	}
}