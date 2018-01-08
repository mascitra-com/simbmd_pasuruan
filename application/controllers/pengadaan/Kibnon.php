<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibnon extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('aset/Kibnon_model', 'kib');
        // $this->load->model('aset/Temp_kiba_model', 'kib_temp');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Spk_model', 'spk');
        $this->load->model('Sp2d_model', 'sp2d');
        $this->load->library('pagination');
	}
	
	public function add($id_spk = NULL)
	{
		if(empty($id_spk))
			show_404();

		$data['spk'] = $this->spk->get($id_spk);
		$data['sp2d'] = $this->sp2d->get_many_by('id_spk', $id_spk);
		$this->render('modules/pengadaan/form_kibnon', $data);
	}

	public function edit($id = NULL)
	{
		if(empty($id))
			show_404();
	
		$data['kib'] = $this->kib->get($id);
		$data['spk'] = $this->spk->get($data['kib']->id_spk);
		$data['sp2d'] = $this->sp2d->get_many_by('id_spk', $data['kib']->id_spk);
		$this->render('modules/pengadaan/form_kibnon', $data);
	}

	public function insert()
	{
		$data = $this->input->post();
        $data['nilai'] 	= unmonefy($data['nilai']);

        if (!$this->kib->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('pengadaan/kibnon/add/'.$data['id_spk']);
		}

		$data_final = array();
		$kuantitas = !empty($data['kuantitas']) ? $data['kuantitas'] : 1;
		unset($data['kuantitas']);

		for ($i=0; $i < $kuantitas; $i++) {
			$data_final[$i] = $data;
		}

		$sukses = $this->kib->batch_insert($data_final);
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('pengadaan/index/rincian/'.$data['id_spk']);
		} else {
			$this->message('Data gagal disimpan','danger');
			$this->go('pengadaan/kibnon/add/'.$data['id_spk']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];
        $data['nilai'] 	= unmonefy($data['nilai']);
        unset($data['id']);

		if (!$this->kib->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('pengadaan/kibnon/edit/'.$id);
		}

		$sukses = $this->kib->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('pengadaan/index/rincian/'.$data['id_spk']);
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go('pengadaan/kibnon/edit/'.$id);
		}
	}

	public function delete($id = NULL)
	{
		if(empty($id))
			show_404();
	
		$data 	= $this->kib->get($id);
		$sukses = $this->kib->delete($id);
		if($sukses) {
			$this->message("Data berhasil dihapus",'success');
			$this->go('pengadaan/index/rincian/'.$data->id_spk);
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('pengadaan/index/rincian/'.$data->id_spk);
		}
	}
}