<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibnon extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('aset/Kibnon_model', 'kib');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->library('pagination');
	}
	
	public function index()
	{
		$filter = $this->input->get();
		$filter['id_organisasi'] = isset($filter['id_organisasi'])?$filter['id_organisasi']:'';
		
		$data['organisasi'] = $this->organisasi->get_data_by_auth();

		$result 			= $this->kib->get_data($filter);
		$data['kib'] 		= $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'inventarisasi/'.get_class($this));
		$data['filter'] 	= (!empty($filter) ? $filter : array('id_organisasi'=>''));

		$this->render('modules/aset/saldo_berjalan/kibnon/index', $data);
	}

	public function add($id = null)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('aset/kibnon');
		}

		$data['org'] = $this->organisasi->get($id);
		$this->render('modules/aset/saldo_berjalan/kibnon/form', $data);
	}

	public function edit($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('aset/kibnon');
		}

		$data['kib'] = $this->kib->get($id);
		$data['org'] = $this->organisasi->get($data['kib']->id_organisasi);
		$this->render('modules/aset/saldo_berjalan/kibnon/form', $data);
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

	// public function undelete($id = NULL)
	// {
	// 	if(empty($id)) {
	// 		$this->message('Pilih organisasi terlebih dahulu', 'danger');
	// 		$this->go('aset/kibnon');
	// 	}

	// 	$sukses = $this->kib->update($id, array('is_deleted'=>0));
	// 	if($sukses) {
	// 		$this->message("Data dihapus berhasil diurungkan.",'success');
	// 		$this->go('aset/kibnon');
	// 	} else {
	// 		$this->message('Data dihapus gagal diurungkan','danger');
	// 		$this->go('aset/kibnon');
	// 	}
	// }
}