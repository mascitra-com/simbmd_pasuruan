<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kib_non extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('aset/Kibnon_model', 'kib');
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Spk_model', 'spk');
		$this->load->model('Hibah_model', 'hibah');
		$this->load->library('pagination');
	}
	
	public function index()
	{
		$filter = $this->input->get();
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4));
		$filter['id_organisasi'] = isset($filter['id_organisasi'])?$filter['id_organisasi']:'';
		
		# Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$filter['id_organisasi'] = $this->auth->get_id_organisasi();
			$data['organisasi'] 	 = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
		}

		$result 			= $this->kib->get_data($filter);
		$data['kib'] 		= $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/'.get_class($this));
		$data['filter'] 	= (!empty($filter) ? $filter : array('id_organisasi'=>''));

		$this->render('modules/aset/kibnon/index', $data);
	}

	public function add($id = null)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('aset/kibnon');
		}

		$data['org'] = $this->organisasi->get($id);
		$this->render('modules/aset/kibnon/form', $data);
	}

	public function add_pengadaan($id_spk = NULL)
	{
		if(empty($id_spk))
			show_404();

		$data['spk'] = $this->spk->get($id_spk);
		$this->render('modules/pengadaan/form_kibnon', $data);
	}

	public function add_hibah($id_hibah = NULL)
	{
		if(empty($id_hibah))
			show_404();

		$data['hibah'] = $this->hibah->get($id_hibah);
		$this->render('modules/hibah/form_kibnon', $data);
	}

	public function edit($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('aset/kibnon');
		}

		$data['kib'] = $this->kib->get($id);
		$data['org'] = $this->organisasi->get($data['kib']->id_organisasi);
		$this->render('modules/aset/kibnon/form', $data);
	}

	public function edit_pengadaan($id = NULL)
	{
		if(empty($id))
			show_404();
	
		$data['kib'] = $this->kib->get($id);
		$data['spk'] = $this->spk->get($data['kib']->id_spk);
		$this->render('modules/pengadaan/form_kibnon', $data);
	}

	public function insert()
	{
		$data = $this->input->post();

        $data['nilai'] 	= unmonefy($data['nilai']);
		if (!$this->kib->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibnon/add/'.$data['id_organisasi']);
        }

		$sukses = $this->kib->insert($data);
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('aset/kibnon/add/'.$data['id_organisasi']);
		} else {
			$this->message('Data gagal disimpan','danger');
			$this->go('aset/kibnon/add/'.$data['id_organisasi']);
		}
	}

	public function insert_pengadaan()
	{
		$data = $this->input->post();
        $data['nilai'] 	= unmonefy($data['nilai']);

        if (!$this->kib->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('aset/kibnon/add_pengadaan/'.$data['id_spk']);
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
			$this->go('pengadaan/rincian/'.$data['id_spk']);
		} else {
			$this->message('Data gagal disimpan','danger');
			$this->go('aset/kibnon/add_pengadaan/'.$data['id_spk']);
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
            $this->go('aset/kibnon/edit/'.$id);
        }

		$sukses = $this->kib->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('aset/kibnon?id_organisasi='.$data['id_organisasi']);
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go('aset/kibnon/edit/'.$id);
		}
	}

	public function update_pengadaan()
	{
		$data = $this->input->post();
		$id   = $data['id'];
        $data['nilai'] 	= unmonefy($data['nilai']);
        unset($data['id']);

		if (!$this->kib->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('aset/kibnon/edit_pengadaan/'.$id);
		}

		$sukses = $this->kib->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('pengadaan/rincian/'.$data['id_spk']);
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go('aset/kibnon/edit_pengadaan/'.$id);
		}
	}

	public function delete($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('aset/kibnon');
		}

		$sukses = $this->kib->update($id, array('is_deleted'=>1));
		if($sukses) {
			$this->message("Data berhasil dihapus, <a href='".site_url('aset/kibnon/undelete/'.$id)."'><b>Urungkan!</b></a>",'success');
			$this->go('aset/kibnon');
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('aset/kibnon');
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

	public function undelete($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('aset/kibnon');
		}

		$sukses = $this->kib->update($id, array('is_deleted'=>0));
		if($sukses) {
			$this->message("Data dihapus berhasil diurungkan.",'success');
			$this->go('aset/kibnon');
		} else {
			$this->message('Data dihapus gagal diurungkan','danger');
			$this->go('aset/kibnon');
		}
	}
}