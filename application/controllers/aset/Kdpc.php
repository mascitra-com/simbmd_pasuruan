<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kdpc extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('aset/Kibc_model', 'kib');
		$this->load->model('Kategori_model', 'kategori');
		$this->load->model('Spk_model', 'spk');
		$this->load->library('pagination');
	}

	public function add_pengadaan($id_spk = NULL)
	{
		if(empty($id_spk))
			show_404();

		$data['spk'] = $this->spk->get($id_spk);
		$this->render('modules/pengadaan/form_kdpc', $data);
	}

	public function edit_pengadaan($id = NULL)
	{
		if(empty($id))
			show_404();
	
		$data['kib'] = $this->kib->get($id);
		$data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
		$data['spk'] = $this->spk->get($data['kib']->id_spk);
		$this->render('modules/pengadaan/form_kdpc', $data);
	}

	public function insert_pengadaan()
	{
		$data = $this->input->post();
		$data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
		
		if (!$this->kib->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('aset/kdpc/add_pengadaan/'.$data['id_spk']);
		}

		$data_final = array();
		$kuantitas = !empty($data['kuantitas']) ? $data['kuantitas'] : 1;
		unset($data['kuantitas']);

		for ($i=0; $i < $kuantitas; $i++) {
			$data_final[$i] = $data;
			$data_final[$i]['reg_barang'] = $this->kib->get_reg_barang($data['id_kategori']) + $i;
			$data_final[$i]['reg_induk']  = $this->kib->get_reg_induk();
		}

		$sukses = $this->kib->batch_insert($data_final);
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('pengadaan/rincian/'.$data['id_spk']);
		} else {
			$this->message('Data gagal disimpan','danger');
			$this->go('aset/kdpc/add_pengadaan/'.$data['id_spk']);
		}
	}

	public function update_pengadaan()
	{
		$data 		   = $this->input->post();
		$data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : NULL;
		$id 		   = $data['id'];
		unset($data['id']);

		if (!$this->kib->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('aset/kdpc/edit_pengadaan/'.$id);
		}

		$sukses = $this->kib->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('pengadaan/rincian/'.$data['id_spk']);
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go('aset/kdpc/edit_pengadaan/'.$id);
		}
	}

	public function delete_pengadaan($id = NULL)
	{
		if(empty($id))
			show_404();
	
		$data 	= $this->kib->get($id);
		$sukses = $this->kib->delete($id);
		if($sukses) {
			$this->message("Data berhasil dihapus",'success');
			$this->go('pengadaan/rincian/'.$data->id_spk);
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('pengadaan/rincian/'.$data->id_spk);
		}
	}
}