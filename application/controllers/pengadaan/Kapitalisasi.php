<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapitalisasi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kapitalisasi_model', 'kapitalisasi');

		$this->load->model('aset/Kibc_model', 'kibc');
		$this->load->model('aset/Kibd_model', 'kibd');

		$this->load->model('Spk_model', 'spk');
		$this->load->model('Sp2d_model', 'sp2d');
	}
	
	public function index()
	{
		show_404();
	}

	public function add($id_spk = null)
	{
		if (empty($id_spk)) {
			show_404();
		}

		$data['spk']  = $this->spk->get($id_spk);
		$data['sp2d'] = $this->sp2d->get_many_by(array('id_spk'=>$id_spk));

		$this->render('modules/pengadaan/form_kapitalisasi', $data);
	}

	public function edit($id = null)
	{
		if (empty($id)) {
			show_404();
		}

		$data['kpt']  = $this->kapitalisasi->subtitute($this->kapitalisasi->get($id));
		$data['spk']  = $this->spk->get($data['kpt']->id_spk);
		$data['sp2d'] = $this->sp2d->get_many_by(array('id_spk'=>$data['kpt']->id_spk));

		$data['kpt']->id_aset = $data['kpt']->golongan == '3' ? $this->kibc->get($data['kpt']->id_aset) : $this->kibd->get($data['kpt']->id_aset);

		$this->render('modules/pengadaan/form_kapitalisasi', $data);
	}

	public function insert()
	{
		$data = $this->input->post();
		$data['nilai'] = unmonefy($data['nilai']);
		$data['nilai_penunjang'] = unmonefy($data['nilai_penunjang']);

		if (!$this->kapitalisasi->form_verify($data)) {
			$this->message('Isi data yang wajib diisi');
			$this->go('pengadaan/kapitalisasi/add/'.$data['id_spk']);
		}
		
		$sukses = $this->kapitalisasi->insert($data);
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('pengadaan/index/rincian/'.$data['id_spk']);
		} else {
			$this->message('Data gagal disimpan');
			$this->go('pengadaan/kapitalisasi/add/'.$data['id_spk']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$data['nilai'] = unmonefy($data['nilai']);
		$data['nilai_penunjang'] = unmonefy($data['nilai_penunjang']);
		$id = $data['id'];
		unset($data['id']);

		if (!$this->kapitalisasi->form_verify($data)) {
			$this->message('Isi data yang wajib diisi');
			$this->go('pengadaan/kapitalisasi/edit/'.$id);
		}

		$sukses = $this->kapitalisasi->update($id, $data);
		
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('pengadaan/index/rincian/'.$data['id_spk']);
		} else {
			# Rollback update
			$this->message('Data gagal disimpan');
			$this->go('pengadaan/kapitalisasi/edit/'.$id);
		}
	}

	public function delete($id = null)
	{
		if(empty($id))
			show_404();

		$kpt = $this->kapitalisasi->get($id);

		$sukses = $this->kapitalisasi->delete($id);
		if($sukses) {
			$this->message('Data berhasil dihapus','success');
		} else {
			$this->message('Data gagal dihapus','danger');
		}
		$this->go('pengadaan/index/rincian/'.$kpt->id_spk);
	}
}