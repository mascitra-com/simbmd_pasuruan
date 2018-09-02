<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapitalisasi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kapitalisasi_model', 'kapitalisasi');
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

	public function insert()
	{
		$data = $this->input->post();
		$data['reg_induk'] = $this->kapitalisasi->get_reg_induk();
		$data['nilai'] = unmonefy($data['nilai']);
		$data['nilai_penunjang'] = unmonefy($data['nilai_penunjang']);

		if (!$this->kapitalisasi->form_verify($data)) {
			$this->message('Isi data yang wajib diisi');
			$this->go('pengadaan/kapitalisasi/add/langkah_3/'.$data['id_spk'].'?id_aset='.$data['id_aset'].'&golongan='.$data['golongan'].'&subsubkelompok='.$data['id_kategori']);
		}
		
		$sukses = $this->kapitalisasi->insert($data);
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('pengadaan/index/rincian/'.$data['id_spk']);
		} else {
			$this->message('Data gagal disimpan');
			$this->go('pengadaan/kapitalisasi/add/langkah_3/'.$data['id_spk'].'?id_aset='.$data['id_aset'].'&golongan='.$data['golongan'].'&subsubkelompok='.$data['id_kategori']);
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
			$this->go('pengadaan/index/rincian/'.$kpt->id_spk);
		} else {
			# Rollback
			$this->{$kib}->update($kpt->id_aset, array('nilai_tambah'=>$temp->nilai_tambah));
			$this->message('Data gagal dihapus','danger');
			$this->go('pengadaan/index/rincian/'.$kpt->id_spk);
		}
	}

	public function get_json_aset()
	{
		$par = $this->input->get();
		
	}
}