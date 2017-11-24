<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organisasi extends MY_Controller {

	public $is_superadmin = 1;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Organisasi_model', 'organisasi');
	}

	public function index()
	{
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>1));
		$this->render('modules/organisasi/index', $data);
	}

	public function unit($id = null)
	{
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>2,'sub_dari'=>$id));
		$data['induk'] 	  	= $this->organisasi->get($id);
		$this->render('modules/organisasi/index_unit', $data);
	}

	public function subunit($id = null)
	{
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>3,'sub_dari'=>$id));
		$data['induk'] 	  	= $this->organisasi->get($id);
		$this->render('modules/organisasi/index_subunit', $data);
	}

	public function upb($id = null)
	{
		$data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4,'sub_dari'=>$id));
		$data['induk'] 	  	= $this->organisasi->get($id);
		$this->render('modules/organisasi/index_upb', $data);
	}

	public function add($jenis = null)
	{
		switch ($jenis) {
			case '2':
				$data['induk'] = $this->organisasi->get($this->input->get('id'));
				$this->render('modules/organisasi/form_unit', $data);
				break;

			case '3':
				$data['induk'] = $this->organisasi->get($this->input->get('id'));
				$this->render('modules/organisasi/form_subunit', $data);
				break;

			case '4':
				$data['induk'] = $this->organisasi->get($this->input->get('id'));
				$this->render('modules/organisasi/form_upb', $data);
				break;
			
			default:
				show_404();
				break;
		}
	}

	public function edit($id = null)
	{
		if (empty($id)) {
			show_404();
		}

		$data['organisasi'] = $this->organisasi->get($id);

		switch ($data['organisasi']->jenis) {
			case '2':
				$this->render('modules/organisasi/form_unit', $data);
				break;

			case '3':
				$this->render('modules/organisasi/form_subunit', $data);
				break;

			case '4':
				$this->render('modules/organisasi/form_upb', $data);
				break;
			
			default:
				show_404();
				break;
		}
	}

	public function insert()
	{
		$data = $this->input->post();
		$ref  = $this->input->get('ref');

		$sukses = $this->organisasi->insert($data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go($ref);
		} else {
			$this->message('Data gagal ditambah','danger');
			$this->go($ref);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$ref  = $this->input->get('ref');
		$id   = $data['id'];

		unset($data['id']); 

		$sukses = $this->organisasi->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go($ref);
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go($ref);
		}
	}

	public function delete($id = null)
	{
		if (empty($id)) {
			show_404();
		}

		$ref = $this->input->get('ref');
		if (empty($ref)) {
			$ref = 'organisasi';
		}

		$sukses = $this->organisasi->delete($id);
		if($sukses) {
			$this->message('Data berhasil dihapus','success');
			$this->go($ref);
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go($ref);
		}
	}

	###### API
	public function get($id)
	{
		$result = $this->organisasi->get_many_by(array('sub_dari'=>$id));
		echo json_encode($result);
	}
}
