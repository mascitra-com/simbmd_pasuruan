<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spk extends MY_Controller
{
	public $is_admin = 1;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Spk_model', 'spk');
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Kegiatan_model', 'kegiatan');
	}
	
	public function index()
	{
		$filter = $this->input->get();
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4));
		
		# Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$filter['id_organisasi'] = $this->auth->get_id_organisasi();
			$data['organisasi'] = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
		}

		$data['spk'] = $this->spk->get_data($filter);
		$data['filter'] = (!empty($filter) ? $filter : array('id_organisasi'=>''));

		$this->render('modules/spk/index', $data);
	}

	public function get($id = '')
	{
		echo json_encode($this->spk->get($id));
	}

	public function add($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('spk');
		}

		$data['organisasi'] = $this->organisasi->get($id);
		$data['kegiatan']   = $this->kegiatan->get_all();
		$this->render('modules/spk/form', $data);
	}

	public function edit($id = NULL)
	{
		if(empty($id)) {
			$this->message('Pilih organisasi terlebih dahulu', 'danger');
			$this->go('spk');
		}

		$data['spk'] 		= $this->spk->get($id);
		$data['kegiatan']   = $this->kegiatan->get_all();
		$data['organisasi'] = $this->organisasi->get($data['spk']->id_organisasi);
		$this->render('modules/spk/form', $data);
	}

	public function insert()
	{
		$data = $this->input->post();
		unset($data['adde']);

		if (!$this->spk->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('spk/add/'.$data['id_organisasi']);
		}

		$sukses = $this->spk->insert($data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go('spk?id_organisasi='.$data['id_organisasi']);
		} else {
			$this->message('Data gagal ditambah','danger');
			$this->go('spk/add/'.$data['id_organisasi']);
		}
	}
 
	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id'], $data['adde']);

		if (!$this->spk->form_verify($data)) {
			$this->message('Isi data yang wajib diisi', 'danger');
			$this->go('spk/edit/'.$id);
		}

		$sukses = $this->spk->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('spk?id_organisasi='.$data['id_organisasi']);
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go('spk/edit/'.$id);
		}
	}

	public function delete($id = NULL)
	{
		if(empty($id))
			show_404();

		$sukses = $this->spk->delete($id);
		if($sukses) {
			$this->message('Data berhasil dihapus','success');
			$this->go('spk');
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('spk');
		}
	}
}